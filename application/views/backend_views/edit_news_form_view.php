<div class="content-box"><!-- Start Content Box -->
				   
	 <div class="content-box-header">
					<h3> <font style="margin-left:270px;">Haber Düzenleme Formu</font></h3>
					<div class="clear"></div>
	 </div> <!-- End .content-box-header -->	
				
				  <div class="content-box-content">	
					
					 <div class="tab-content default-tab" id="1">
					
						<form action="{base}backend/news/updateNews" method="post">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p>
									<label> Haber Tarihi :  </label>
									<input class="text-input large-input" type="text" style="color:black" id="datepicker" name="news_date_field" value="{haber_tarihi}"/>
								</p>
								</br>
                                
								<p>
									<label> Haber İçeriği :  </label>
									<input class="text-input large-input" type="text" style="color:black" id="large-input" name="news_detail_field" value="{haber_detayi}"/>
								</p>
								<input class="text-input large-input" type="hidden" name="id" value="31{id}"/>
								</br>
								
								<p>
									<input class="button" type="submit" value="Haberi Güncelle" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div>  <!-- End #tab1 -->      
					
				</div> <!-- End .content-box-content -->                     
                
			</div> <!-- End .content-box -->