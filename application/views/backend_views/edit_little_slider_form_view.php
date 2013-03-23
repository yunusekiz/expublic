			<div class="content-box"><!-- Start Content Box -->
				   
			 	<div class="content-box-header">
					<h3> <font style="margin-left:240px;">Küçük Slider Güncelleme Formu</font></h3>
					<div class="clear"></div>
			 	</div> <!-- End .content-box-header -->	
				
				
				  <div class="content-box-content">	

					 <div class="tab-content default-tab" id="1">
					
						<form action="{base}backend/slider/updateLittleSlider" method="post" enctype="multipart/form-data">
					{bir_adet_kucuk_slider_detayi_a}
							<br /><br />
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								<p class="cocukdiv_image">
								<!--<input type="file" name="resimler[]" class="multi" accept="gif|jpg|png" /><br />-->
                                
                                <div style="float:left;"><label style="font-size:16px;"><b>Küçük Slider ın Mevcut Resmi : </b></label></div>
                                <div class="cocukdiv_image" style="float:left; margin-top:-25px; margin-left:40px;">
                                	<a href="{base}{buyuk_resim}" title="{resim_baslik}" >
                                		<img src="{base}{kucuk_resim}" width="80" height="60" title="{resim_baslik}"/>
                                	</a>
                                </div>
                                <div class="clear"></div>
                                <div style="float:left; margin-top:20px;"><label>(Bilgi ::: yeni bir resim yüklerseniz, bu resim otomatikman silinir) </label></div>
                                <div class="clear"></div>
                                	<br/>
								<input type="file" name="little_slider_update_form_field_image" accept="image/*" />
									<br/>
								</p><hr>
								<br /><br />														
					{/bir_adet_kucuk_slider_detayi_a}

					{bir_adet_kucuk_slider_detayi_b}			
								<p>
									<label style="font-size:16px;"><b>Resim Başlığı :</b></label>
									<input class="text-input large-input" type="text"
									style="color:#000;" id="large-input" name="title_little_slider_update_form_field" 
									value="{resim_baslik}" />
								</p><br />
								
								<p>
									<label style="font-size:16px;"><b>Resim Detayı :</b></label>
									<input class="text-input large-input" type="text"
									style="color:#000; font-size:9px;" id="large-input" name="detail_little_slider_update_form_field" 
									value="{resim_detay}" />
									<input class="text-input large-input" type="hidden" name="id_little_slider_update_form_field" value="0.31{id}"/>
								</p><br />

								<p>
									<label><b style="font-size:16px;">Resim Tarihi : </b> </label>
									<input class="text-input large-input" type="text" style="color:black" id="datepicker" name="date_little_slider_update_form_field" value="{resim_tarih}" />
						
								</p><br />
								
								<p>
									<input class="button" type="submit" value="Kaydı Güncelle" />
								</p>
								
							</fieldset>
						{/bir_adet_kucuk_slider_detayi_b}
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div>  <!-- End #tab1 -->      
					
				</div> <!-- End .content-box-content -->                     
                
			</div> <!-- End .content-box -->