			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3><font style="margin-left:270px;">Kayıtlı Tüm Referanslar</font></h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
			   
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
					
					<form action="{base}backend/reference/operation" method="post">
						
						<table>
							
							<thead>
								<tr>
									<th>Düzenle</th>
								    <th><font style="margin-left:11px; margin-right:20px;">Sil</font></th>
								    <th><font style="margin-left:1px; margin-right:20px;">Resim</font></th>
								    <th>Kategori</th>
								    <th>Tarih</th>
								    <th>Başlık</th>
								    <th>Açıklama</th>
								</tr>
								
							</thead>
						 
						 
							<tbody>
								 {referans_detaylari}
								<tr>
									<td><input type="radio" name="reference_radio_field" value="0.31{ref_id}"/><a href="#" title="Düzenle"><img src="{base}assets/backend_assets/images/icons/pencil.png" alt="Düzenle" /></a></td>
									<td><input type="radio" name="reference_radio_field" value="1.31{ref_id}"/><a href="#" title="Sil"><img src="{base}assets/backend_assets/images/icons/cross.png" alt="Sil" /></a></td>
									<td class="cocukdiv_image">
										<a href="{base}{buyuk_resim}" title="{baslik}">
										 	<img src="{base}{kucuk_resim}" width="45" height="45" style="margin-bottom:-8px;" title="{baslik}" />
										</a>
									</td>
									<td>{kategori}</td>
									<td>{tarih}</td>
									<td>{baslik}</td>
									<td>{aciklama}</td>
								</tr>
								 {/referans_detaylari}

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