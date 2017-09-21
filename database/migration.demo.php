<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateItemTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_temp', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->string('o_id',50)->notNull()->comment('订单编号');
            $table->string('outer_oi_id',50)->default(null)->comment('子订单号');
            $table->string('sku_id')->notNull()->comment('商家SKU');
            $table->string('name',100)->default(null)->comment('商品名称');
            $table->decimal('amount',12,2)->default(0.00)->comment('应付金额');
            $table->decimal('base_price',12,2)->default(0.00)->comment('基本价（拍下价格）');
            $table->decimal('price',12,2)->default(0.00)->comment('');
            $table->string('properties_value',100)->default(null)->comment('属性');
            $table->integer('qty')->default(0)->comment('购买数量');
            $table->string('raw_so_id',50)->default(null)->comment('');
            $table->string('refund_id',50)->default(null)->comment('退货ID');
            $table->integer('refund_qty')->default(0)->comment('退货数量');
            $table->string('refund_status',40)->default(null)->comment('退货状态');
            $table->string('shop_sku_id')->default(null)->comment('网站对应的自定义SKU编号');

        });

       
        DB::unprepared('
            CREATE TRIGGER `sync_to_item_table`
            BEFORE INSERT
            ON `item_temp` FOR EACH ROW
            BEGIN
                IF NOT EXISTS(SELECT id FROM `item` WHERE o_id = new.o_id AND sku_id = new.sku_id ) THEN
                    INSERT INTO `item`(o_id,outer_oi_id,sku_id,name,amount,base_price,price,properties_value,qty,raw_so_id,refund_id,refund_qty,refund_status,shop_sku_id)
                    VALUES(new.o_id,new.outer_oi_id,new.sku_id,new.name,new.amount,new.base_price,new.price,new.properties_value,new.qty,new.raw_so_id,new.refund_id,new.refund_qty,new.refund_status,new.shop_sku_id);
                ELSE
                    UPDATE `item` SET
                    outer_oi_id = new.outer_oi_id,
                    name = new.name,
                    amount = new.amount,
                    base_price = new.base_price,
                    price = new.price,
                    properties_value = new.properties_value,
                    qty = new.qty,
                    raw_so_id = new.raw_so_id,
                    refund_id = new.refund_id,
                    refund_qty = new.refund_qty,
                    refund_status = new.refund_status,
                    shop_sku_id = new.shop_sku_id
                    WHERE o_id = new.o_id AND sku_id = new.sku_id;
                END IF;
            END
        ');


        DB::unprepared('
            CREATE EVENT IF NOT EXISTS `clear_item_temp`
            ON SCHEDULE
            EVERY 1 DAY
            DO TRUNCATE `item_temp`
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('item_temp');
        DB::unprepared('DROP TRIGGER IF EXISTS `sync_to_item_table`');
        DB::unprepared('DROP EVENT IF EXISTS `clear_item_temp`');

    }
}