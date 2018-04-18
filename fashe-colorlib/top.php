<?php 
include_once('fonctions.php');
ConnectDB();

if(isset($_POST['toArticle']))
{
    header("Location: product-detail.php?modelid=$toModel&articleid=$toArticle");
}
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
						<a href='cart.php'><img src="images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON"></a>
						<span class="header-icons-noti">
                            <?php
                                echo panier();
                            ?>
                        </span>
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
						<a href='cart.php'><img src="images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON"></a>
						<span class="header-icons-noti">
							<?php echo panier(); ?>
						</span>
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