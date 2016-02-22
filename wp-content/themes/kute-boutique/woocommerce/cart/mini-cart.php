<?php  global $woocommerce; ?>
<div class="widget_shopping_cart_content">
    <div class="mini-cart">
        <a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
            <span class="icon pe-7s-cart"></span> 
            <span class="count"><?php echo WC()->cart->cart_contents_count ?></span>
            <span class="text"><?php esc_html_e('My Cart','kute-boutique'); ?></span>
            <span class="sub-total"><?php echo balanceTags( $woocommerce->cart->get_cart_subtotal() )  ?></span>
        </a>
        <?php if ( ! WC()->cart->is_empty() ) : ?>
        <div class="show-shopping-cart">
            <h3 class="title">
                <?php echo sprintf (_n( 'YOU HAVE <span class="text-primary">(%d ITEM)</span> IN YOUR CART', 'YOU HAVE <span class="text-primary">(%d ITEMS)</span> IN YOUR CART', WC()->cart->cart_contents_count, 'kute-boutique' ), WC()->cart->cart_contents_count ); ?>
            </h3>
            <ul class="list-product">
                <?php  foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ): ?>
                    <?php $bag_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key ); ?>
                    <?php $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key ); ?>
                        
                    <?php if ( $bag_product &&  $bag_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ): ?> 
                    
                        <?php $product_name  = apply_filters( 'woocommerce_cart_item_name', $bag_product->get_title(), $cart_item, $cart_item_key );?>
                        <?php $thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $bag_product->get_image('shop_thumbnail'), $cart_item, $cart_item_key );?>
                        <?php $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $bag_product ), $cart_item, $cart_item_key );?>
                        <li>
                            <div class="thumb">
                                <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                            </div>
                            <div class="info">
                                <h4 class="product-name">
                                    <a href="<?php echo esc_url( get_permalink( $cart_item[ 'product_id' ] ) )  ?>"><?php echo esc_html( $product_name ) ; ?></a>
                                </h4>
                                <span class="price"><?php echo balanceTags( $product_price ) ?></span>
                                <?php
                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                        '<a href="%s" class="remove remove-item" title="%s" data-product_id="%s" data-product_sku="%s"><i class="fa fa-close"></i></a>',
                                        esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
                                        esc_html__( 'Remove this item', 'kute-boutique' ),
                                        esc_attr( $product_id ),
                                        esc_attr( $bag_product->get_sku() )
                                    ), $cart_item_key );
                                ?>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <div class="sub-total">
                <?php esc_html_e( 'Subtotal', 'kute-boutique' ) ?>:<?php echo balanceTags( $woocommerce->cart->get_cart_subtotal() )  ?>
            </div>
            
            <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
            
            <div class="group-button">
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button"><?php esc_html_e( 'Shopping Cart', 'kute-boutique' ) ?></a>
                <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="check-out button"><?php esc_html_e( 'CheckOut', 'kute-boutique' ) ?></a>
            </div>
        </div>
        <?php else: ?>
        <div class="show-shopping-cart cart-empty">
            <h3 class="title">
                <?php esc_html_e( 'No products in the cart.', 'kute-boutique' ); ?>
            </h3>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>
