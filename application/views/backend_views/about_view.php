<div class="content-box"><!-- Start Content Box -->
				   
	 <div class="content-box-header">
					<h3> <font style="margin-left:270px;">Hakkımızda Metnini Düzenleme Formu</font></h3>
					<div class="clear"></div>
	 </div> <!-- End .content-box-header -->	
				
				  <div class="content-box-content">	
					
					 <div class="tab-content default-tab" id="1">
					
						<form action="{base}backend/about/controlAboutUs" method="post">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
																							
								<p>
									<label><b>Biz Kimiz?</b></label>
									<textarea class="text-input textarea wysiwyg" id="textarea" name="about_field" cols="5" rows="5">{about}</textarea>
								</p><br /><br />
                                
                                <p>
									<label><b>Vizyonumuz</b></label>
									<textarea class="text-input textarea wysiwyg" id="textarea" name="vision_field" cols="5" rows="5">{vision}</textarea>
								</p>
								
								<p>
									<label><b>Misyonumuz</b></label>
									<textarea class="text-input textarea wysiwyg" id="textarea" name="mission_field" cols="5" rows="5">{mission}</textarea>
								</p><br /><br />
								<!--biseyler girin : <input type="text" name="textt">-->
								
								<p>
									<input class="button" type="submit" value="Kaydet" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div>  <!-- End #tab1 -->      
					
				</div> <!-- End .content-box-content -->                     
                
			</div> <!-- End .content-box -->