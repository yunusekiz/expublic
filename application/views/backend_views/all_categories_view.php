			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3><font style="margin-left:270px;">Kayıtlı Tüm Kategoriler</font></h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
			   
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
					
					<form action="{base}backend/reference/operationCategory" method="post">
						
						<table>
							
							<thead>
								<tr>
									<th></th>
								    <th>Kategoriyi Düzenle</th>
								    <th></th>
								    <th>Referans Kategori Adı</th>
								</tr>
								
							</thead>
						 
							<tbody>
								{referans_kategorileri}
								<tr>
									<td></td>
									<td><input type="radio" name="category_radio_field" value="0.32{cat_id}"/><a href="#" title="Düzenle"><img src="{base}assets/backend_assets/images/icons/pencil.png" alt="Düzenle" /></a></td>
									<td></td>
									<td>{kategori}</td>
								</tr>
								{/referans_kategorileri}

							</tbody>
							
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											{submit_button_css}
											<input type="submit" class="button" value="Seçili Eylemi Uygula" />
											{/submit_button_css}
										</div>
										<!-- <a class="button" href="#">Seçili Eylemi Uygula</a> -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
<!--
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<select name="dropdown">
												<option value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
											<a class="button" href="#">Apply to selected</a>
										</div>
										
										<div class="pagination">
											<a href="#" title="First Page">&laquo; First</a><a href="#" title="Previous Page">&laquo; Previous</a>
											<a href="#" class="number" title="1">1</a>
											<a href="#" class="number" title="2">2</a>
											<a href="#" class="number current" title="3">3</a>
											<a href="#" class="number" title="4">4</a>
											<a href="#" title="Next Page">Next &raquo;</a><a href="#" title="Last Page">Last &raquo;</a>
										</div>
										<div class="clear"></div>
-->
									</td>
								</tr>
							</tfoot>							


						</table>

					  </form>	
						
					</div> <!-- End #tab1 -->
					     
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->