			<div class="content-box"><!-- Start Content Box -->
				   
			 	<div class="content-box-header">
					<h3> <font style="margin-left:240px;">Referans Kategorisi Düzenleme Formu</font></h3>
					<div class="clear"></div>
			 	</div> <!-- End .content-box-header -->	
				
				
				  <div class="content-box-content">	
					
					 <div class="tab-content default-tab" id="1">
					
						<form action="{base}backend/reference/updateCategory" method="post" enctype="multipart/form-data">
							<br /><h3> Kategorinin Adı : </h3><br />
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								{referans_kategorisi}
								<p>
									<label>Kategorinin Mevcut Adı : </label>               
									<input class="text-input large-input" type="text"
									style="color:#736F6E;" id="large-input" name="readonly_category_field" readonly="readonly" value="{kategori}"
									/><br /><br />
									<label>(Bilgi ::: değiştirmek için, aşağıdaki kutuya yeni bir isim girip onaylayın)</label> 
								</p>
								{/referans_kategorisi}


								<hr>
								{referans_kategorisi_update}
								<p>
									<label style="font-size:16px;"><b></b></label>
									<input class="text-input large-input" type="text"
									style="color:#000; font-size:9px;" id="large-input" name="category_name_field" 
									value="{kategori}" />
									<input class="text-input large-input" type="hidden" name="id_field" value="0.32{cat_id}"/>
								</p>
								{/referans_kategorisi_update}
								<p>
									<input class="button" type="submit" value="Kategoriyi Güncelle" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div>  <!-- End #tab1 -->      
					
				</div> <!-- End .content-box-content -->                     
                
			</div> <!-- End .content-box -->