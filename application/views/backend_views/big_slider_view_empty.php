 <br /><br /><br />
<div class="content-box"><!-- Start Content Box -->
				          
             <div class="content-box-header">
				<h3> <font style="margin-left:230px;">Anasayfa Büyük Slider Düzenleme Formu</font></h3>
							 
			</div> <!-- End .content-box-header -->     
			
           		<div class="content-box-content">
            					
					<div class="tab-content default-tab" id="1">                 
					
						<form action="{base}backend/slider/imageUploadToBigSlider" method="post" enctype="multipart/form-data" >
						
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->											

								<p>
									<label> Slider' da hiç resim yok :((  </label>
								</p>

							</fieldset>
              <div class="clear"></div><!-- End .clear -->        
                    
                   <br/><hr><br/>
                  
              <p>
                  <label> Slider' a yeni resim yüklemek için dosya seçin :  </label>
              </p>
								
                  <input type="file" name="big_slider_image_form_field" accept="image/*" />
                   <br/><br/><br/>
              <p>
								<label> Seçtiğiniz resme isim verin :  </label>
								<input class="text-input large-input" type="text" style="color:black" id="large-input" name="big_slider_title_form_field" />
							</p>
							</br>
							<p>
								<input class="button" type="submit" value="Yeni Resmi Kaydet" />
							</p> 
						</form>
						
					</div>  <!-- End #tab1 -->      
					
				</div> <!-- End .content-box-content -->                      
                
			</div> <!-- End .content-box --> 