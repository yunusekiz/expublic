			<div class="content-box"><!-- Start Content Box -->
				   
			 	<div class="content-box-header">
					<h3> <font style="margin-left:240px;">Yeni Referans Ekleme Formu</font></h3>
					<div class="clear"></div>
			 	</div> <!-- End .content-box-header -->	
				
				
				  <div class="content-box-content">	
					
					 <div class="tab-content default-tab" id="1">
					
						<form action="{base}backend/reference/controlReference" method="post" enctype="multipart/form-data">
							<br /><h3> Referans Kategorisi : </h3><br />
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								<p>
									<label>Kayıtlı Kategorilerden Birini Seçin  </label>              
									<select name="reference_dropdown_category" class="small-input" style="color:#000;">
										<option value="0"> Kategori Seçiniz</option>
										{referans_kategorileri}
										<option value="{ref_category_name}">{ref_category_name}</option>
										{/referans_kategorileri}
									</select> 
								</p><br /><br />
								
								<p>
									<label>Veya Yeni Bir Kategori Ekleyin  </label>
									<input class="text-input large-input" type="text"
									style="color:#000;" id="large-input" name="reference_text_category" 
									/>
								</p><hr width="100%" style="margin-top:10px;" />
							
						<p><br />
									<label style="font-size:16px;"><b>Referans Tarihi :</b></label>
									
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
										true;" placeholder="Yıl"  required="required" />
						</p>	<br /><br />
								
								<p><label><b style="font-size:16px;">Referans Resmi</b> </label>
								<!--<input type="file" name="resimler[]" class="multi" accept="gif|jpg|png" /><br />-->
                                <input type="file" name="reference_image_form_field" accept="image/*" />
                                </p>
								
								<hr>
									<br /><br />														
								<p>
									<label style="font-size:16px;"><b>Referans Başlığı :</b></label>
									<input class="text-input large-input" type="text"
									style="color:#000;" id="large-input" name="reference_title" 
									value="" />
								</p><br /><br />
								
								<p>
									<label style="font-size:16px;"><b>Referans Açıklaması :</b></label>
									<input class="text-input large-input" type="text"
									style="color:#000; font-size:9px;" id="large-input" name="reference_detail" 
									value="" />
								</p>
								
								<p>
									<input class="button" type="submit" value="Referansı Kaydet" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div>  <!-- End #tab1 -->      
					
				</div> <!-- End .content-box-content -->                     
                
			</div> <!-- End .content-box -->