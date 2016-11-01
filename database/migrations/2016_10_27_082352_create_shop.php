<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShop extends Migration
{
    /**
     * https://github.com/amsgames/laravel-shop#database-setup
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing carts
        /*
         * id — Cart id.
            user_id — Owner.
            items — Items in cart.
            count — Total amount of items in cart.
            totalPrice — Total price from all items in cart.
            totalTax — Total tax from all items in cart, plus global tax set in config.
            totalShipping — Total shipping from all items in cart.
            total — Total amount to be charged, sums total price, total tax and total shipping.
            displayTotalPrice — Total price value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            displayTotalTax — Total tax value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            displayTotalShipping — Total shipping value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            displayTotal — Total amount value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            created_at — When the cart record was created in the database.
            updated_at — Last time when the cart was updated.
         */
        Schema::create('shop_cart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->bigInteger('items');
            $table->integer('count');
            $table->decimal('totalPrice');
            $table->decimal('totalTax');
            $table->decimal('totalShipping');
            $table->decimal('total');
            $table->decimal('displayTotalPrice');
            $table->decimal('displayTotalTax');
            $table->decimal('displayTotalShipping');
            $table->decimal('displayTotal');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique('user_id');
        });
        // Create table for storing items
        /*
         * id — Item id.
            sku — Stock Keeping Unit, aka your unique product identification within your store.
            price — Item price.
            tax — Item tax. Defaulted to 0.
            shipping — Item shipping. Defaulted to 0.
            currency — Current version of package will use USD as default.
            quantity — Item quantity.
            class — Class reference of the model being used as shoppable item. Optional when using array data.
            reference_id — Id reference of the model being used as shoppable item. Optional when using array data.
            user_id — Owner.
            displayPrice — Price value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            displayTax — Tax value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            displayShipping — Tax value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            displayName — Based on the model's item name property.
            shopUrl — Based on the model's item route property.
            wasPurchased — Flag that indicates if item was purchased. This base on the status set in config file.
            created_at — When the item record was created in the database.
            updated_at — Last time when the item was updated.
         */
        Schema::create('shop_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->bigInteger('cart_id')->unsigned()->nullable();
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->string('sku');
            $table->decimal('price', 20, 2);
            $table->decimal('tax', 20, 2)->default(0);
            $table->decimal('shipping', 20, 2)->default(0);
            $table->string('currency')->nullable();
            $table->integer('quantity')->unsigned();
            $table->string('class')->nullable();
            $table->string('reference_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('cart_id')
                ->references('id')
                ->on('shop_cart')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['sku', 'cart_id']);
            $table->unique(['sku', 'order_id']);
            $table->index(['user_id', 'sku']);
            $table->index(['user_id', 'sku', 'cart_id']);
            $table->index(['user_id', 'sku', 'order_id']);
            $table->index(['reference_id']);
        });
        // Create table for storing coupons
        Schema::create('shop_coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('description', 1024)->nullable();
            $table->string('sku');
            $table->decimal('value', 20, 2)->nullable();
            $table->decimal('discount', 3, 2)->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
            $table->index(['code', 'expires_at']);
            $table->index(['code', 'active']);
            $table->index(['code', 'active', 'expires_at']);
            $table->index(['sku']);
        });
        // Create table for storing coupons
        Schema::create('shop_order_status', function (Blueprint $table) {
            $table->string('code', 32);
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->primary('code');
        });
        // Create table for storing carts
        /*
         * id — Order id or order number.
            user_id — Owner.
            items — Items in order.
            transactions — Transactions made on order.
            statusCode — Status code.
            count — Total amount of items in order.
            totalPrice — Total price from all items in order.
            totalTax — Total tax from all items in order, plus global tax set in config.
            totalShipping — Total shipping from all items in order.
            total — Total amount to be charged, sums total price, total tax and total shipping.
            displayTotalPrice — Total price value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            displayTotalTax — Total tax value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            displayTotalShipping — Total shipping value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            displayTotal — Total amount value formatted for shop display. i.e. "$9.99" instead of just "9.99".
            created_at — When the order record was created in the database.
            updated_at — Last time when the order was updated.
         */
        Schema::create('shop_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('statusCode', 32);
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('statusCode')
                ->references('code')
                ->on('shop_order_status')
                ->onUpdate('cascade');
            $table->index(['user_id', 'statusCode']);
            $table->index(['id', 'user_id', 'statusCode']);
        });
        // Create table for storing transactions
        /*
         * id — Order id or order number.
            order — Items in order.
            gateway — Gateway used.
            transaction_id — Transaction id returned by gateway.
            detail — Detail returned by gateway.
            token — Token for gateway callbacks.
            created_at — When the order record was created in the database.
            updated_at — Last time when the order was updated.
         */
        Schema::create('shop_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->string('gateway', 64);
            $table->string('transaction_id', 64);
            $table->string('detail', 1024)->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
            $table->foreign('order_id')
                ->references('id')
                ->on('shop_order')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->index(['order_id']);
            $table->index(['gateway', 'transaction_id']);
            $table->index(['order_id', 'token']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shop_transaction');
        Schema::drop('shop_order');
        Schema::drop('shop_order_status');
        Schema::drop('shop_coupon');
        Schema::drop('shop_item');
        Schema::drop('shop_cart');
    }
}
