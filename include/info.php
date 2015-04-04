<?php
	include("option.php");
?>
<div class="modal fade" id="info">
			<div class="modal-dialog">
				<div class="modal-content">
					
					<div class="modal-header">
						<h3>
							<label class="label label-primary">
								個人資訊
							</label>
						</h3>
					</div>

					<div class="modal-body">
						帳號:
						<span id="Username"></span>
						<a id="changePW_btn" href="update_pw.php" target="_blank">更變密碼</a>
						<br><br>
						
						<div class="form-inline">
							暱稱:
							<input id="Nickname" class="form-control"/>
						</div><br>

						<div class="form-inline">
							性別:
							<select id="Sex" class="form-control">
								<option>男</option>
								<option>女</option>
							</select>
						</div><br>
						
						<div class="form-inline">
							出生年份:
							<select id="Birth" class="form-control">
								<?php for($i=1970;$i<=2015;$i++){ //for?>
								<option><?php echo $i ;?></option>
								<?php } //for?>
							</select>
						</div><br>

						<div class="form-inline">
							居住縣市:
							<select id="city" class="form-control"></select>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<select id="town" class="form-control"></select>
						</div>
						<br>

						<div id="update_info_success" class="alert alert-success" style="display:none;">
							更新成功!
						</div>
						
					</div>

					<div class="modal-footer">
						<button class="btn btn-sm btn-success" id="update_info_btn">更新</button>
						<button class="btn btn-sm btn-danger" data-dismiss="modal">取消</button>
					</div>

				</div>
			</div>
		</div>