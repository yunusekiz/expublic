			<div class="content-box"><!-- Start Content Box -->
				   
			 	<div class="content-box-header">
					<h3> <font style="margin-left:240px;">Yeni Kategori Ekleme Formu</font></h3>
					<div class="clear"></div>
			 	</div> <!-- End .content-box-header -->	
				
				
				  <div class="content-box-content">	
					
					 <div class="tab-content default-tab" id="1">
					
						<form action="{base}backend/reference/addCategory" method="post" enctype="multipart/form-data">
							<br /><h3> Yeni Kategorinin Adı : </h3>
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								<p>
									<label> </label>               
									<input class="text-input large-input" type="text"
									style="color:#736F6E;" id="large-input" name="category_name_field" />
									<br /><br />
									<label>(Bilgi ::: kategori eklemek için, yukarıdaki kutucuğa yeni bir isim girip onaylayın)</label>
									<input class="text-input large-input" type="hidden" name="id_field" value="0.32{cat_id}"/> 
								</p>


								<hr>
								<p>
									<input class="button" type="submit" value="Kategoriyi Kaydet" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div>  <!-- End #tab1 -->      
					
				</div> <!-- End .content-box-content -->                     
                
			</div> <!-- End .content-box -->