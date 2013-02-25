 <br /><br /><br />
<div class="content-box"><!-- Start Content Box -->
				          
             <div class="content-box-header">
				<h3> <font style="margin-left:230px;">Anasayfa Sabit Resimleri Düzenleme Formu</font></h3>
							 
			</div> <!-- End .content-box-header -->     
			
           		<div class="content-box-content">
            					
					<div class="tab-content default-tab" id="1">                 
					
						<form action="{base}backend/slider/imageUploadToStaticImages" method="post" enctype="multipart/form-data" >
						
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->											

								<p>
									<label> Slider' ın mevcut resimleri </label>
								</p>
								<div class="anadiv_cerceve_dis">
                 
                  				{sabit_resim_detaylari}
									<div class="anadiv_cerceve_ic">
         								<div class="cocukdiv_image">
            								<a href="{base}{buyuk_resim}" title="{resim_baslik}">
                								<img src="{base}{kucuk_resim}" width="80" height="80" alt="" />
            								</a>
          								</div>
          							<a href="deleteStaticImages/{id}">
          								<div class="cocukdiv_icon"><img src="{base}assets/backend_assets/lightbox_images/delete.png" title="Resmi Sil" /></div>
          								<div class="cocukdiv_icon_text"> Resmi Sil</div>  
          							</a>
									</div>
                  				{/sabit_resim_detaylari}
                                          
								</div>
							</fieldset>
              <div class="clear"></div><!-- End .clear -->        
                    
                   <br/><hr><br/>
                  
              <p>
                  <label> Slider' a yeni resim yüklemek için dosya seçin :  </label>
              </p>
								
                  <input type="file" name="static_images_form_field" accept="image/*" />
                   <br/><br/><br/>
              				<p>
								<label> Seçtiğiniz resme isim verin :  </label>
								<input class="text-input large-input" type="text" style="color:black" id="large-input" name="static_images_title_form_field" />
							</p>
							<br/>
              				<p>
								<label> Seçtiğiniz resme detay bilgisi girin :  </label>
								<input class="text-input large-input" type="text" style="color:black" id="large-input" name="static_images_detail_form_field" />
							</p>
							</br>
							<p>
								<input class="button" type="submit" value="Yeni Resmi Kaydet" />
							</p>  
						</form>
						
					</div>  <!-- End #tab1 -->      
					
				</div> <!-- End .content-box-content -->                      
                
			</div> <!-- End .content-box --> 