<?php

if (!function_exists('mm_disable_function_for_user_role')) {
    function mm_disable_function_for_user_role ($post_id) {
        global $pagenow, $post;
        if (is_admin() && is_user_logged_in()) {
            $current_user = wp_get_current_user();
            // page yith gift cards
            if (!in_array('administrator', $current_user->roles) && !in_array('developer', $current_user->roles)) { 
                ?>
                    <script type="text/javascript">
                        const yithItem = document.getElementById('toplevel_page_yith_plugin_panel');
                        const yithTabs = document.querySelectorAll('.yith-plugin-fw-tabs .yith-plugin-fw-tab-element');
                        if (yithTabs.length > 0) {
                            yithTabs.forEach((tab, i) => {
                                if (i == 0) {
                                    return;
                                }
                                tab.style.display = "none";
                            });
                        }
                        if (yithItem) {
                            yithItem.style.display = "none";
                        }
                    </script>
                <?php
            }
            // page edit and add new
            if ( in_array( $pagenow, array( 'post-new.php', 'post.php' ) )) {
                $post_type = $_GET['post_type'];
                if(empty($post_type) && isset($_GET['post'])){
                    $post_type = get_post_type($_GET['post']);
                }
                if (!in_array('administrator', $current_user->roles) && ((empty($post_type) && in_array( $pagenow, array( 'post-new.php' ))) || $post_type == 'page' || $post_type == 'product' || $post_type == 'post')) {
                    ?>
                        <script type="text/javascript">
                            const submitForReviewAction = document.querySelector('#publishing-action #publish[value="Submit for Review"]');
                            const publishAction = document.querySelector('#publishing-action #publish[value="Publish"]');
                            const deleteAction = document.querySelector('#delete-action');
                            const editPostStatus = document.querySelector('a.edit-post-status');

                            <?php if (!in_array('manager', $current_user->roles)) { ?>
                                if (publishAction) {
                                    publishAction.style.display = "none";
                                }
                            <?php } ?>

                            if (deleteAction) {
                                deleteAction.style.display = "none";
                            }
                            if (submitForReviewAction) {
                                submitForReviewAction.style.display = "none";
                            }
                            if (editPostStatus) {
                                editPostStatus.style.display = "none";
                            }
                        </script>
                    <?php
                        if ((in_array('media', $current_user->roles) || in_array('qa', $current_user->roles) || in_array('manager', $current_user->roles)) && (isset($post) && $post->post_type != 'product')) {
                            ?>
                                <script type="text/javascript">
                                    if (publishAction) {
                                        publishAction.style.display = "block";
                                    }
                                    if (editPostStatus) {
                                        editPostStatus.style.display = "block";
                                    }
                                    if (deleteAction) {
                                        deleteAction.style.display = "block";
                                    }
                                </script>
                            <?php
                        }

                        // writer, media
                        if (in_array('editor', $current_user->roles) || in_array('media', $current_user->roles)) {
                            ?>
                                <script type="text/javascript">
                                    const editVisiable = document.querySelector('a.edit-visibility');
                                    if (editVisiable) {
                                        editVisiable.style.display = "none";
                                    }
                                </script>
                            <?php
                        }
                    ?>
                    <?php if (!in_array('manager', $current_user->roles) && (in_array('media', $current_user->roles) || in_array('qa', $current_user->roles) || in_array('manager', $current_user->roles))) { ?>
                        <?php if (isset($post) && $post->post_type === 'product') { ?>
                            <script type="text/javascript">
                                if (publishAction) {
                                    publishAction.setAttribute("value", "Private publish");
                                }
                                const visitPrivate = document.getElementById('visibility-radio-private');
                                const visitPublic = document.getElementById('visibility-radio-public');
                                const lableVisitPublic = document.querySelector('[for="visibility-radio-public"]');
                                if (visitPrivate) {
                                    visitPrivate.addEventListener('change', function() {
                                        if (this.checked) {
                                            if (publishAction) {
                                                publishAction.style.display = "";
                                            } else {
                                                publishAction.style.display = "none";
                                            }
                                        }
                                    });
                                }
                                if (visitPublic && lableVisitPublic) {
                                    visitPublic.style.display = "none";
                                    lableVisitPublic.style.display = "none";
                                }
                            </script>
                    <?php
                        }
                    }                    
                }
                if (!in_array('administrator', $current_user->roles) && !in_array('developer', $current_user->roles) && !in_array('manager', $current_user->roles) && !in_array('qa', $current_user->roles) && !in_array('media', $current_user->roles)) {
                    ?>
                        <script type="text/javascript">
                            const blockByIds = ['layout', 'avia_product_hover', 'slider_revolution_metabox', 'mm_metaboxes_option'];
                            blockByIds.forEach(e => {
                                if (document.getElementById(e)) {
                                    document.getElementById(e).style.display = "none";
                                }
                            });
                        </script>
                    <?php
                }
                if (in_array('inter', $current_user->roles)) {
                    ?>
                        <script type="text/javascript">
                            const blockByIds2 = ['admin-speedup-postcustom', 'woocommerce-product-data', 'tagsdiv-product_tag', 'uap_affiliate_landing_page', 'product_catdiv', 'certificatesdiv', 'authordiv', 'advanced-sortables', 'yoast_internal_linking', 'woocommerce-product-images', 'product_notes_metabox', 'postimagediv'];
                            blockByIds2.forEach(e => {
                                if (document.getElementById(e)) {
                                    document.getElementById(e).style.display = "none";
                                }
                            });
                        </script>
                    <?php
                }
                if (in_array('media', $current_user->roles)) {
                    ?>
                        <script type="text/javascript">
                            const blockByIds3 = ['admin-speedup-postcustom', 'woocommerce-product-data', 'tagsdiv-product_tag', 'uap_affiliate_landing_page', 'product_catdiv', 'certificatesdiv', 'authordiv', 'advanced-sortables', 'yoast_internal_linking', 'product_notes_metabox'];
                            blockByIds3.forEach(e => {
                                if (document.getElementById(e)) {
                                    document.getElementById(e).style.display = "none";
                                }
                            });
                        </script>
                    <?php
                }
                if (in_array('shop_manager', $current_user->roles)) {
                    ?>
                        <script type="text/javascript">
                            const blockByIds4 = ['admin-speedup-postcustom', 'certificatesdiv', 'tagsdiv-product_tag', 'postimagediv', 'product_catdiv', 'woocommerce-product-images'];
                            blockByIds4.forEach(e => {
                                if (document.getElementById(e)) {
                                    document.getElementById(e).style.display = "none";
                                }
                            });
                        </script>
                    <?php
                }
            }
            // page list
            if ( in_array( $pagenow, array( 'edit.php' ) ) || in_array( $pagenow, array( 'edit-tags.php' ) ) ) {
                if (!in_array('administrator', $current_user->roles)) {
                    ?>
                        <script type="text/javascript">
                            const btnTrash = document.querySelectorAll('#the-list .row-actions span.trash');
                            const btnDel = document.querySelectorAll('#the-list .row-actions span.delete');
                            const optionDel = document.querySelector('select#bulk-action-selector-top option[value="delete"]');
                            const clearOptions = document.querySelector('select#bulk-action-selector-top option[value="tcproductclear"]');
                            if (btnTrash.length > 0) {
                                btnTrash.forEach(e => e.style.display = "none");
                            }
                            if (btnDel.length > 0) {
                                btnDel.forEach(e => e.style.display = "none");
                            }
                            if (optionDel) {
                                optionDel.style.display = "none";
                            }
                            if (clearOptions) {
                                clearOptions.style.display = "none";
                            }
                        </script>
                    <?php
                }
                if (!in_array('administrator', $current_user->roles) && !in_array('developer', $current_user->roles) && !in_array('manager', $current_user->roles)) {
                    ?>
                        <script type="text/javascript">
                            const btnDup = document.querySelectorAll('#the-list .row-actions span.duplicate');
                            if (btnDup.length > 0) {
                                btnDup.forEach(e => e.style.display = "none");
                            }
                        </script>
                    <?php
                }
                if (in_array('qa', $current_user->roles) || in_array('media', $current_user->roles)) {
                    if ($_GET['taxonomy'] == 'product_tag') {
                        ?>
                            <script type="text/javascript">
                                const btnDelTagsProduct = document.querySelectorAll('#the-list .row-actions span.delete');
                                if (btnDelTagsProduct.length > 0) {
                                    btnDelTagsProduct.forEach(e => e.style.display = '');
                                }
                            </script>
                        <?php
                    }
                    
                    if ($_GET['page'] == 'tm-global-epo') {
                        ?>
                            <script type="text/javascript">
                                const btnTrashGO = document.querySelectorAll('#the-list .row-actions span.trash');
                                if (btnTrashGO.length > 0) {
                                    btnTrashGO.forEach(e => e.style.display = '');
                                }
                            </script>
                        <?php
                    }
                }
                // Sale agent and Sale manager
                if (in_array('shop_manager', $current_user->roles) || in_array('salemanager', $current_user->roles)) {
                    if ($_GET['post_type'] == 'sliced_invoice' || $_GET['post_type'] == 'sliced_quote' || $_GET['post_type'] == 'shop_coupon') {
                        ?>
                            <script type="text/javascript">
                                if (btnTrash.length > 0) {
                                    btnTrash.forEach(e => e.style.display = 'block');
                                }
                            </script>
                        <?php
                    }
                }
                // Writer
                if (in_array('editor', $current_user->roles) && $_GET['post_type'] != 'page' && $_GET['post_type'] != 'product' && !empty($_GET['post_type'])) {
                    ?>
                        <script type="text/javascript">
                            if (btnTrash.length > 0) {
                                btnTrash.forEach(e => e.style.display = "block");
                            }
                            if (btnDel.length > 0) {
                                btnDel.forEach(e => e.style.display = "block");
                            }
                            if (optionDel) {
                                optionDel.style.display = "block";
                            }
                            if (clearOptions) {
                                clearOptions.style.display = "block";
                            }
                        </script>
                    <?php
                }
                // Manager, sale agent, sale manager
                if ((in_array('manager', $current_user->roles) || in_array('shop_manager', $current_user->roles) || in_array('salemanager', $current_user->roles)) && $_GET['post_type'] != 'product') {
                    ?>
                        <script type="text/javascript">
                            if (btnTrash.length > 0) {
                                btnTrash.forEach(e => e.style.display = "block");
                            }
                            if (btnDel.length > 0) {
                                btnDel.forEach(e => e.style.display = "block");
                            }
                            if (optionDel) {
                                optionDel.style.display = "block";
                            }
                            if (clearOptions) {
                                clearOptions.style.display = "block";
                            }
                        </script>
                    <?php
                }
            }
            // page plugin ultimate affiliates pro
            if ($_GET['page'] == 'ultimate_affiliates_pro' && !in_array('administrator', $current_user->roles) && !in_array('developer', $current_user->roles)) {
                ?>
                    <script type="text/javascript">
                        const tabSetting = document.querySelectorAll('.uap-dashboard-menu > ul > li');
                        if (tabSetting[tabSetting.length - 1]) {
                            tabSetting[tabSetting.length - 1].style.display = "none";
                        }
                        if (tabSetting[9]) {
                            tabSetting[9].style.display = "none";
                        }
                        if (tabSetting[5]) {
                            tabSetting[5].style.display = "none";
                        }
                    </script>
                <?php
            }
            // page list user
            if ( in_array( $pagenow, array( 'users.php' ) ) ) {
                if (!in_array('administrator', $current_user->roles)) {
                    ?>
                        <script type="text/javascript">
                            const btnSwitchTo = document.querySelectorAll('#the-list .row-actions span.switch_to_user');
                            if (btnSwitchTo.length > 0) {
                                btnSwitchTo.forEach(e => e.style.display = "none");
                            }
                        </script>
                    <?php
                }
            }
        }
    }
    add_action('admin_footer', 'mm_disable_function_for_user_role');
}

if (!function_exists('mm_allow_assign_role_add_user')) {
    function mm_allow_assign_role_add_user ($all_roles) {
        $current_user = wp_get_current_user();
    
        if (in_array('salemanager', $current_user->roles)) {
            unset($all_roles["salemanager"]);
            $all_roles['shop_manager'] = array(
                'name' => 'Sale Agent'
            );
            return $all_roles;
        }

        if (in_array('manager', $current_user->roles)) {
            unset($all_roles["manager"]);
            $all_roles['shop_manager'] = array(
                'name' => 'Sale Agent'
            );
            $all_roles['salemanager'] = array(
                'name' => 'Sale Manager'
            );
            return $all_roles;
        }

        if (in_array('developer', $current_user->roles)) {
            unset($all_roles["developer"]);
            $all_roles['shop_manager'] = array(
                'name' => 'Sale Agent'
            );
            $all_roles['salemanager'] = array(
                'name' => 'Sale Manager'
            );
            return $all_roles;
        }

        if (in_array('qa', $current_user->roles)) {
            unset($all_roles["qa"]);
            $all_roles['shop_manager'] = array(
                'name' => 'Sale Agent'
            );
            $all_roles['salemanager'] = array(
                'name' => 'Sale Manager'
            );
            return $all_roles;
        }

        if (in_array('media', $current_user->roles)) {
            unset($all_roles["media"]);
            $all_roles['shop_manager'] = array(
                'name' => 'Sale Agent'
            );
            $all_roles['salemanager'] = array(
                'name' => 'Sale Manager'
            );
            return $all_roles;
        }

        return $all_roles;
    }
    add_filter('editable_roles', 'mm_allow_assign_role_add_user');
}

if (!function_exists('mm_fix_link_btn_option_global_extra_product')) {
    function mm_fix_link_btn_option_global_extra_product () {
        if ($_GET['page'] == 'tm-global-epo') {
        ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const btnOptions = document.querySelectorAll('.product_page_tm-global-epo ul.subsubsub > li > a');
                    if (btnOptions.length > 0) {
                        btnOptions.forEach(e => {
                            let btnHref = e.getAttribute('href');
                            if (btnHref && btnHref.includes('post_type=tm_global_cp')) {
                                btnHref = btnHref.replace('post_type=tm_global_cp', 'post_type=product&page=tm-global-epo');
                                console.log(btnHref);
                                e.setAttribute('href', btnHref);
                            }
                        });
                    }
                });
            </script>
        <?php
        }
    }
    add_action('admin_footer', 'mm_fix_link_btn_option_global_extra_product');
}