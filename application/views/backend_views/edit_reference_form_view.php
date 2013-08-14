			<div class="content-box"><!-- Start Content Box -->
				   
			 	<div class="content-box-header">
					<h3> <font style="margin-left:240px;">Referans Düzenleme Formu</font></h3>
					<div class="clear"></div>
			 	</div> <!-- End .content-box-header -->	
				
				
				  <div class="content-box-content">	
					
					 <div class="tab-content default-tab" id="1">
					
						<form action="{base}backend/reference/updateReference" method="post" enctype="multipart/form-data">
							<br /><h3> Referans Kategorisi : </h3><br />
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								{referans_kategori_update}
								<p>
									<label>Referansın Mevcut Kategorisi : </label>               
									<input class="text-input large-input" type="text"
									style="color:#736F6E;" id="large-input" name="readonly_category_field" readonly="readonly" value="{kategori}"
									/><br /><br />
									<label>(Bilgi ::: değiştirmek için, kayıtlı kategorilerden birini seçebilirsiniz)</label> 
								</p><br />
								{/referans_kategori_update}

								<p>
									<label>Kayıtlı Kategoriler : </label>              
									<select name="reference_dropdown_category_field" class="small-input" style="color:#000;">
										<option value="0"> Kategori Seçiniz</option>
										{referans_kategorileri}
										<option value="{kategori}">{kategori}</option>
										{/referans_kategorileri}
									</select> 
								</p><hr width="100%" style="margin-top:10px;" /><br /><br />

								{referans_detaylari_update}

									<label><b style="font-size:16px;">Referans Tarihi : </b> </label>
									<input class="text-input large-input" type="text" style="color:black" id="datepicker" name="reference_date_field" value="{tarih}" />
						
<!-- 									<label style="font-size:16px;"><b>Referans Tarihi :</b></label>
									
									</label>
									<input name="reference_day" type="text" style="width:25px"  
								 		maxlength="11" value="{day}" onfocus="if(this.beenchanged!=true){ this.value = ''}"
										onblur="if(this.beenchanged!=true) { this.value='{day}' }" onchange="this.beenchanged = 
										true;" placeholder="Gün" required="required" /> 						 
									<input name="reference_month" type="text" style="width:24px" 
								 		maxlength="11" value="{month}" onfocus="if(this.beenchanged!=true){ this.value = ''}"
										onblur="if(this.beenchanged!=true) { this.value='{month}' }" onchange="this.beenchanged = 
										true;" placeholder="Ay" required="required" /> 
									<input name="reference_year" type="text" style="width:45px" 
								 		maxlength="11" value="{year}" onfocus="if(this.beenchanged!=true){ this.value = ''}"
										onblur="if(this.beenchanged!=true) { this.value='{year}' }" onchange="this.beenchanged = 
										true;" placeholder="Yıl"  required="required" /> -->
						</p><hr width="100%" style="margin-top:10px;" /><br /><br /><br />
								
								<p class="cocukdiv_image"><label><b style="font-size:16px;">Referans Resmi : </b> </label>
								<!--<input type="file" name="resimler[]" class="multi" accept="gif|jpg|png" /><br />-->
                                <input type="file" name="reference_image_form_field" accept="image/*" />
                                <br/> <br/> <br/>
                                <div style="float:left;"><label><b style="font-size:16px;">Referansın Mevcut Resmi : </b></label></div>
                                <div class="cocukdiv_image" style="float:left; margin-top:-25px; margin-left:40px;">
                                	<a href="{base}{buyuk_resim}" title="{baslik}" >
                                		<img src="{base}{kucuk_resim}" width="70" height="60" width="mevcut referans resmi" />
                                	</a>
                                </div>
                                <div class="clear"></div>
                                <div style="float:left; margin-top:20px;"><label>(Bilgi ::: yeni bir resim yüklerseniz, bu resim otomatikman silinir) </label></div>

                                </p>
								<div class="clear"></div>
								<hr>
									<br /><br />														
								<p>
									<label style="font-size:16px;"><b>Referans Başlığı :</b></label>
									<input class="text-input large-input" type="text"
									style="color:#000;" id="large-input" name="reference_title_field" 
									value="{baslik}" />
								</p><br /><br />
								
								<p>
									<label style="font-size:16px;"><b>Referans Açıklaması :</b></label>
									<input class="text-input large-input" type="text"
									style="color:#000; font-size:9px;" id="large-input" name="reference_detail_field" 
									value="{aciklama}" />
									<input class="text-input large-input" type="hidden" name="id_field" value="0.31{ref_id}"/>
									<input class="text-input large-input" type="hidden" name="images_id" value="{resim_id}"/>
								</p>
								
								<p>
									<input class="button" type="submit" value="Referansı Güncelle" />
								</p>

								{/referans_detaylari_update}
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div>  <!-- End #tab1 -->      
					
				</div> <!-- End .content-box-content -->                     
                
			</div> <!-- End .content-box -->