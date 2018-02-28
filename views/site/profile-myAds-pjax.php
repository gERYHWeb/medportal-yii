<?php
                        $per_page = 10;
                        $num_page = ceil(count($data_my_ads) / $per_page);
                        //print_r($num_page);

                        foreach ($data_my_ads as $key => $val) {

                            //for ( $key = $x; )
                            /*                             * ***************************
                              echo '<pre>';
                              print_r($data_my_ads);
                              echo '</pre>';
                             * *************************************
                             */
                            isset($data_my_ads[$key]['attribute']['main_image']['value']) ? $main_img = $data_my_ads[$key]['attribute']['main_image']['value'] : $main_img = '';
                            isset($data_my_ads[$key]['symbol_currency']) ? $symbol_currency = $data_my_ads[$key]['symbol_currency'] : $symbol_currency = '';
                            isset($data_my_ads[$key]['price']) ? $price = $data_my_ads[$key]['price'] : $price = '';
                            isset($data_my_ads[$key]['attribute']['title']['value']) ? $title = $data_my_ads[$key]['attribute']['title']['value'] : $title = '';
                            isset($data_my_ads[$key]['name_category']) ? $name_category = $data_my_ads[$key]['name_category'] : $name_category = '';
                            isset($data_my_ads[$key]['date_create']) ? $date_create = $data_my_ads[$key]['date_create'] : $date_create = '';
                            isset($data_my_ads[$key]['count_views']) ? $count_views = $data_my_ads[$key]['count_views'] : $count_views = '';
                            ?>
                            <!-- ads-item  --> 
                            <div class="ads-item">
                                <!-- item-image -->
                                <div class="item-image-box ">
                                    <div class="item-image">
                                        <a href="details.html"><img src="<?php echo "images/" . $main_img; ?>" alt="Image" class="img-responsive"></a>
                                    </div>
                                </div>
                                <!-- item-image -->

                                <!-- item-info -->                                    
                                <div class="item-info ">
                                    <div class="ads-info">
                                        <h3 class="item-price"><?php echo $symbol_currency . $price; ?></h3>
                                        <h4 class="item-title"><a href="#"><?php echo $title ?></a></h4>
                                        <div class="item-cat">
                                            <span><a href="#"><?php echo $title ?></a></span> /
                                            <span><a href="#">Tv &amp; Video</a></span>
                                        </div>                                      
                                    </div>


                                    <div class="ads-meta">
                                        <div class="meta-content">
                                            <span class="dated">Posted On: <a href="#"><?php echo $date_create ?> </a></span><br>
                                            <span class="visitors"><?php echo "Visitors: " . $count_views ?></span> 
                                        </div>                                      
                                    </div>
                                </div>
                                <!-- item-info --> 

                                <!-- btn-option --> 
                                <div class="user-option ">
                                    <a class="edit-item" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit this ad"><i class="fa fa-pencil"></i></a>
                                    <a class="delete-item" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete this ad"><i class="fa fa-times"></i></a>
                                </div> 
                                <!-- btn-option --> 

                            </div>
                            <!-- ads-item  --> 
                        <?php } ?> 

                        <div class="pagination-box">
                            <ul class="pagination">
                                <li class="disabled"><a href="#"><span class="caret"><i class="fa fa-angle-left" aria-hidden="true"></i></span></a></li>
                                <?php for ($i = 1; $i <= $num_page; $i++) { ?>
                                    <li ><a href="my-ads-page"><span><?= $i ?></span></a></li>
            <?php } ?>

                                <li><a href="#"><span class="caret"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                            </ul>
                        </div>