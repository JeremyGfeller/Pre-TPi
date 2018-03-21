<?php 
include_once('fonctions.php');
ConnectDB();
extract($_SESSION);
?>

<header class="header1">
		<!-- Header desktop -->
		<div class="container-menu-header">
			<div class="topbar">
				<div class="topbar-social">
					<a href="#" class="topbar-social-item fa fa-facebook"></a>
					<a href="#" class="topbar-social-item fa fa-instagram"></a>
					<a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
					<a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
					<a href="#" class="topbar-social-item fa fa-youtube-play"></a>
				</div>

				<div class="topbar-child2">
					<span class="topbar-email">
						<?php echo afficherLogin(); ?>
					</span>
				</div>
			</div>

			<div class="wrap_header">
				<!-- Logo -->
				<a href="index.php" class="logo">
					<img src="images/icons/logo.png" alt="IMG-LOGO">
				</a>

				<!-- Menu -->
				<div class="wrap_menu">
					<nav class="menu">
						<ul class="main_menu">
							<li>
								<a href="index.php">Accueil</a>
							</li>

							<li>
								<a href="product.php">Articles</a>
								<ul class="sub_menu">
									<li><a href="product.php?typearticle=1">Habits</a></li>
									<li><a href="product.php?typearticle=2">Chaussures</a></li>
									<li><a href="product.php?typearticle=3">Sac à dos</a></li>
								</ul>
							</li>

							<li>
								<a href="contact.php">Contact</a>
							</li>

							<li>
								<a href="cart.php">Panier</a>
							</li>

							<?php 
                                if(@$_SESSION['role'] == 0 & @$_SESSION['UserName'] != "")
                                {
                                    echo "
                                    <li>
                                        <a href='admin.php'>Administration</a>
                                        <ul class='sub_menu'>
                                            <li><a href='addArticle.php'>Ajouter un article</a></li>
                                        </ul>
                                    </li>";
                                }
                            ?>							
						</ul>
					</nav>
				</div>

				<!-- Header Icon -->
				<div class="header-icons">
					<a href="connexion.php" class="header-wrapicon1 dis-block">
						<img src="images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
					</a>

					<span class="linedivide1"></span>

					<div class="header-wrapicon2">
						<img src="images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
						<span class="header-icons-noti">
                            <?php
                                    /*$query = "SELECT count(id_basket) as sumArticle, id_users, id_orderlist, orderlist.quantity FROM basket
                                            inner join orderlist on fk_basket = id_basket
                                            inner join users on fk_users = id_users
                                            WHERE fk_users = $IDPersonne;";  

                                    $sumArticles = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);*/
                                                                  
                                    if(isset($_SESSION['IDPersonne']))
                                    {
                                        echo "1";
                                    }
                                    else
                                    {
                                        echo "0";
                                    }
                                
                            ?>
                        </span>

						<!-- Header cart noti -->
						<div class="header-cart header-dropdown">
                                <?php
                                    if(isset($_SESSION['IDPersonne']))
                                    {
                                        $query = "SELECT id_basket, id_users, id_article, color, id_orderlist, size, illustration, orderlist.quantity, users_lastName, users_role, model_name, model_prix, brand FROM basket
                                              inner join orderlist on fk_basket = id_basket
                                              inner join users on fk_users = id_users
                                              inner join article on fk_article = id_article
                                              inner join size on fk_size = id_size
                                              inner join color on fk_color = id_color
                                              inner join model on fk_model = id_model
                                              inner join brand on fk_brand = id_brand
                                              WHERE fk_users = $IDPersonne;";

                                        $baskets = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

                                        while($basket = $baskets->fetch())
                                        {
                                            extract($basket); // $id_basket, $id_users, $id_article, $color, $id_orderlist, $users_firstName, $size, $illustration, $orderlist.quantity, $users_lastName, $users_role, $model_name, $model_prix, $brand
                                            echo "
                                            <ul class='header-cart-wrapitem'>
                                                <li class='header-cart-item'>
                                                    <div class='header-cart-item-img'>
                                                        <img src='images/articles/$illustration' alt='IMG'>
                                                    </div>

                                                    <div class='header-cart-item-txt'>
                                                        <a href='cart.php' class='header-cart-item-name'>
                                                            $brand - $model_name en $color
                                                        </a>

                                                        <span class='header-cart-item-info'>
                                                            $model_prix.-
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>";
                                        }
                                    }
                                    else
                                    {
                                        echo "Veuillez vous connecter";
                                    }
                                ?>

							<div class="header-cart-total">
								<?php
                                    if(isset($_SESSION['IDPersonne']))
                                    {
                                        $query = "SELECT id_orderlist, orderlist.quantity, fk_article, fk_basket, sum(model_prix) as total FROM yonik.orderlist
                                                  inner join article on fk_article = id_article
                                                  inner join model on fk_model = id_model
                                                  inner join basket on fk_basket = id_basket
                                                  where fk_users = (select fk_users from basket where fk_users = $IDPersonne);";
                                        $additions = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

                                        if ($additions->rowCount() > 0)
                                        {
                                            $addition = $additions->fetch(); 
                                            extract($addition); //$id_users, $users_firstName, $users_lastName, $users_role, $users_login, $users_password, $hashPassword
                                        }
                                        
                                        if($total != 0)
                                        {
                                            echo "Total: $total.-";
                                        }
                                        else
                                        {
                                            echo "Panier vide";
                                        }
                                    }
                                ?>
							</div>

							<div class="header-cart-buttons">
								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="cart.php" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										View Cart
									</a>
								</div>

								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										Check Out
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap_header_mobile">
			<!-- Logo moblie -->
			<a href="index.php" class="logo-mobile">
				<img src="images/icons/logo.png" alt="IMG-LOGO">
			</a>

			<!-- Button show menu -->
			<div class="btn-show-menu">
				<!-- Header Icon mobile -->
				<div class="header-icons-mobile">
					<a href="connexion.php" class="header-wrapicon1 dis-block">
						<img src="images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
					</a>

					<span class="linedivide2"></span>

					<div class="header-wrapicon2">
						<img src="images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
						<span class="header-icons-noti">0</span>

						<!-- Header cart noti -->
						<div class="header-cart header-dropdown">
							<ul class="header-cart-wrapitem">
								<li class="header-cart-item">
									<div class="header-cart-item-img">
										<img src="images/item-cart-01.jpg" alt="IMG">
									</div>

									<div class="header-cart-item-txt">
										<a href="#" class="header-cart-item-name">
											White Shirt With Pleat Detail Back
										</a>

										<span class="header-cart-item-info">
											1 x $19.00
										</span>
									</div>
								</li>

								<li class="header-cart-item">
									<div class="header-cart-item-img">
										<img src="images/item-cart-02.jpg" alt="IMG">
									</div>

									<div class="header-cart-item-txt">
										<a href="#" class="header-cart-item-name">
											Converse All Star Hi Black Canvas
										</a>

										<span class="header-cart-item-info">
											1 x $39.00
										</span>
									</div>
								</li>

								<li class="header-cart-item">
									<div class="header-cart-item-img">
										<img src="images/item-cart-03.jpg" alt="IMG">
									</div>

									<div class="header-cart-item-txt">
										<a href="#" class="header-cart-item-name">
											Nixon Porter Leather Watch In Tan
										</a>

										<span class="header-cart-item-info">
											1 x $17.00
										</span>
									</div>
								</li>
							</ul>

							<div class="header-cart-total">
								Total: $75.00
							</div>

							<div class="header-cart-buttons">
								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="cart.php" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										View Cart
									</a>
								</div>

								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										Check Out
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</div>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="wrap-side-menu" >
			<nav class="side-menu">
				<ul class="main-menu">
					<li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
						<div class="topbar-child2-mobile">
							<span class="topbar-email">
                                <?php echo afficherLogin(); ?>
							</span>
						</div>
					</li>

					<li class="item-topbar-mobile p-l-10">
						<div class="topbar-social-mobile">
							<a href="#" class="topbar-social-item fa fa-facebook"></a>
							<a href="#" class="topbar-social-item fa fa-instagram"></a>
							<a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
							<a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
							<a href="#" class="topbar-social-item fa fa-youtube-play"></a>
						</div>
					</li>

					<li class="item-menu-mobile">
						<a href="index.php">Accueil</a>
					</li>

					<li class="item-menu-mobile">
						<a href="product.php">Articles</a>
                        <ul class="sub-menu">
							<li><a href="product.php?typearticle=1">Habits</a></li>
							<li><a href="product.php?typearticle=2">Chaussures</a></li>
							<li><a href="product.php?typearticle=3">Sac à dos</a></li>
						</ul>
						<i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i>
					</li>

					<li class="item-menu-mobile">
						<a href="contact.php">Contact</a>
					</li>

					<li class="item-menu-mobile">
						<a href="cart.php">Panier</a>
					</li>

					<?php 
						if(@$_SESSION['role'] == 0 & @$_SESSION['UserName'] != "")
						{
							echo "
								<li class='item-menu-mobile'>
									<a href='admin.php'>Administration</a>
									<ul class='sub-menu'>
									<li><a href='addArticle.php'>Ajouter un article</a></li>
									</ul>
									<i class='arrow-main-menu fa fa-angle-right' aria-hidden='true'></i>
								</li>
							";
						}
					?>	
				</ul>
			</nav>
		</div>
	</header>