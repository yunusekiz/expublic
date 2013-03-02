 <br /><br /><br />
<div class="content-box"><!-- Start Content Box -->
				          
             <div class="content-box-header">
				<h3> <font style="margin-left:230px;">Anasayfa Küçük Slider Düzenleme Formu</font></h3>
							 
			</div> <!-- End .content-box-header -->     
			
           		<div class="content-box-content">
            					
					<div class="tab-content default-tab" id="1">                 
					
						<form action="{base}backend/slider/imageUploadToLittleSlider" method="post" enctype="multipart/form-data" >
						
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->											

								<p>
									<label> Anasayfada hiç "Küçük Slider" resmi yok :((  </label>
								</p>

							</fieldset>
              <div class="clear"></div><!-- End .clear -->        
                    
                   <br/><hr><br/>
                  
              <p>
                  <label> Küçük Slider' a yeni resim yüklemek için dosya seçin :  </label>
              </p>
								
                  <input type="file" name="little_slider_image_form_field" accept="image/*" />
                   <br/><br/><br/>
              				<p>
								<label> Seçtiğiniz resme isim verin :  </label>
								<input class="text-input large-input" type="text" style="color:black" id="large-input" name="little_slider_title_form_field" />
							</p>
							<br/>
              				<p>
								<label> Seçtiğiniz resme detay bilgisi girin : </label>
								<input class="text-input large-input" type="text" style="color:black" id="large-input" name="little_slider_detail_form_field" />
							</p>
							<br/>
              				<p>
								<label> Seçtiğiniz resim için bir tarih girin : </label>
								<input class="text-input large-input" type="text" style="color:black" id="datepicker" name="little_slider_date_form_field" />
							</p>
							<br/>							
							<p>
								<input class="button" type="submit" value="Yeni Resmi Kaydet" />
							</p>
						</form>
						
					</div>  <!-- End #tab1 -->      
					
				</div> <!-- End .content-box-content -->                      
                
			</div> <!-- End .content-box --> 