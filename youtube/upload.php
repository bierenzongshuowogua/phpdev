	<?php 
		require_once('./includes/head.php');
	 	require_once('./includes/classes/VideoDetailsFormProvider.php');
	?>			

				<div class="form-warpper">
					<div class="column">
						<?php
							$formprovider = new VideoDetailsFormProvider($con);
							echo $formprovider->createUploadForm();
						?>
					</div>
						<!--加载loading图片，处理视频上传等待过程 -->
							<script class="javascript">
								$("form").submit(function(){
									$("#loadingModal").modal("show");
								});
							</script>	
					
							<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-body">
										视频上传中...
										<img src="assets/imgs/mengmengda.gif" />
										</div>
								  </div>
						 	   </div>
						  </div>				



				</div>
									


			</div>
		</div>
	
	</div>
</body>
</html>
