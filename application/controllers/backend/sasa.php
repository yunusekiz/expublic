<div id="body-wrapper" > <!-- Wrapper for the radial gradient background -->
		
		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
			<h1 id="sidebar-title"><a href="#">Admin Template</a></h1>
		  
			<!-- Logo (221px wide) -->
			<a href="#"><img id="logo" src="images/logo.png" alt="Simpla Admin logo" /></a>
		  
			<!-- Sidebar Profile links -->
			<div id="profile-links">

				<br />
				<a href="index.php?islem=sifre_duzenle" title="Şifremi Değiştir" style="color:#9F6">Şifremi Değiştir</a> |
                <a href="index.php?islem=oturumu_kapat" title="Oturumu Kapat" style="color:#F00">Oturumu Kapat</a>
			</div>        
			
			<ul id="main-nav">  <!-- Accordion Menu -->
				
				<li>
					<a href="index.php" class="nav-top-item no-submenu"><!-- Add the class "no-submenu" to menu items with no sub menu -->
						Anasayfa
					</a>       
				</li>
				

				<li> 
					<a href="index.php?modul=referanslar" class="'.$modul_referanslar.'"> <!-- Add the class "current" to current menu item -->
					Resim Galerisi
					</a>
					<ul>
						<li><a href="index.php?modul=referanslar&islem=referans_ekle" class="current">Galeriye Resim Ekle</a></li>
						<li><a href="index.php?modul=referanslar&islem=referans_duzenle" class="">Galeriyi Düzenle</a></li> <!-- Add class "current" to sub menu items also -->
						
					</ul>
				</li>				
				
				
				<li> 
					<a href="index.php?modul=referanslar" class="'.$modul_referanslar.'"> <!-- Add the class "current" to current menu item -->
					Referanslar
					</a>
					<ul>
						<li><a href="index.php?modul=referanslar&islem=referans_ekle" class="'.$referans_ekle.'">Referans Ekle</a></li>
						<li><a href="index.php?modul=referanslar&islem=referans_duzenle" class="'.$referans_duzenle.'">Referansları Düzenle</a></li> <!-- Add class "current" to sub menu items also -->
						
					</ul>
				</li>
				<li>
					<a href="index.php?modul=belgeler" class="nav-top-item">
						Belgelerimiz
					</a>
					<ul>
						<li><a href="index.php?modul=belgeler&islem=belge_ekle" class="">Yeni Belge Ekle</a></li>
						<li><a href="index.php?modul=belgeler&islem=belge_duzenle" class="">Belgeleri Düzenle</a></li>						
					</ul>
			
				</li>				
				
				

				<li>
					<a href="index.php?modul=haberler" class="'.$modul_haberler.'">
						Haberler
					</a>
					<ul>
						<li><a href="index.php?modul=haberler&islem=yeni_haber_ekle" class="'.$haber_ekle.'">Haber Ekle</a></li>
						<li><a href="index.php?modul=haberler&islem=haber_duzenle" class="'.$haber_duzenle.'">Haberleri Düzenle</a></li>
					</ul>
				</li>
				<li>
					<a href="index.php?modul=site_ayar" class="nav-top-item">
						Site ayarları
					</a>
					<ul>
						<li><a href="#">SEO Ayarları</a></li>
						<li><a href="#">Domain Ayarları</a></li>
					</ul>
				</li>                       
				
			</ul> <!-- End #main-nav -->
			
			<div id="messages" style="display: none"> <!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->
				
				<h3>3 Messages</h3>
			 
				<p>
					<strong>17th May 2009</strong>User<br />
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>
			 
				<p>
					<strong>2nd May 2009</strong>User<br />
					Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>
			 
				<p>
					<strong>25th April 2009</strong>User<br />
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>
				
				<form action="" method="post">
					
					<h4>New Message</h4>
					
					<fieldset>
						<textarea class="textarea" name="textfield" cols="79" rows="5"></textarea>
					</fieldset>
					
					<fieldset>
					
						<select name="dropdown" class="small-input">
							<option value="option1">Send to...</option>
							<option value="option2">Everyone</option>
							<option value="option3">Admin</option>
							<option value="option4">Admin</option>
						</select>
						
						<input class="button" type="submit" value="Send" />
						
					</fieldset>
					
				</form>
				
			</div> <!-- End #messages -->
			
		</div></div> <!-- End #sidebar -->
        
        		<div id="main-content"> <!-- Main Content Section with everything -->	
				
			
			<!-- Page Head -->
			<h2>Hoşgeldiniz</h2>
			<p id="page-intro">Ne Yapmak İstersiniz?</p>
			
			<ul class="shortcut-buttons-set">
				
				<li><a class="shortcut-button" href="index.php?islem=hakkimizda_duzenle"><span>
					<img src="images/icons/about_us_48.png" alt="icon" /><br />
					Hakkımızda Metnini Düzenle
				</span></a></li>
				
				<li><a class="shortcut-button" href="index.php?islem=iletisim_duzenle"><span>
					<img src="images/icons/contact_48.png" alt="icon" /><br />
					İletişim Bilgilerini Düzenle
				</span></a></li>
				
				<li><a class="shortcut-button" href="index.php?islem=hizmet_duzenle"><span>
					<img src="images/icons/services_48.png" alt="icon" /><br />
					Hizmetlerimiz Metnini Düzenle
				</span></a></li>
				<li><a class="shortcut-button" href="index.php?islem=yeni_haber_ekle"><span>
					<img src="images/icons/news_48.png" alt="icon" /><br />
					Yeni Bir Haber Ekle
				</span></a></li>
				<li><a class="shortcut-button" href="index.php?islem=galeriye_resim_ekle" ><!--rel="modal"-->  <span>
					<img src="images/icons/gallery_48.png" alt="icon" /><br />
					Galeriye Resim Ekle
				</span></a></li>
                
				<li><a class="shortcut-button" href="index.php?islem=yeni_referans_ekle" ><!--rel="modal"-->  <span>
					<img src="images/icons/references_45.gif" alt="icon" /><br />
					Yeni Bir Referans Ekle
				</span></a></li>                
				
			</ul><!-- End .shortcut-buttons-set -->
            
            <div class="clear"></div>
            
			<!-- Start Notifications -->