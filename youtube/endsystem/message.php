			<?php	
					require_once("./includes/classes/User.php");
					require_once("./../includes/config.php");
					$test = 11;
					$user = new User($con,1);
					$data = $user->getUserInfo();
					$total = $user->getCount();
			?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="css/amazeui.min.css" />
		 <link rel="stylesheet" href="css/admin.css" />
	</head>
	<body>
		<div class="admin-content-body">
      <div class="am-cf am-padding am-padding-bottom-0">
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">管理员信息</strong><small></small></div>
      </div>

      <hr>

      <div class="am-g">
        <div class="am-u-sm-12 am-u-md-6">
          <div class="am-btn-toolbar">
            <div class="am-btn-group am-btn-group-xs">
            </div>
          </div>
        </div>
        <div class="am-u-sm-12 am-u-md-3">
    
        </div>
        <div class="am-u-sm-12 am-u-md-3">
          <div class="am-input-group am-input-group-sm">
            <input type="text" class="am-form-field" placeholder="请输入留言信息">
          <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" type="button">搜索</button>
          </span>
          </div>
        </div>
      </div>
      <div class="am-g">
        <div class="am-u-sm-12">
          <form class="am-form">
            <table class="am-table am-table-striped am-table-hover table-main">
              <thead>
              <tr>
                <th class="table-check"><input type="checkbox"></th><th class="table-id">ID</th><th class="table-title">用户名</th><th class="table-type">姓名</th><th class="table-author am-hide-sm-only">邮箱</th><th class="table-date am-hide-sm-only">注册日期</th><th class="table-set">操作</th>
              </tr>
              </thead>
              <tbody>
			<?php 
				echo $data;
			?>
              </tbody>
            </table>
            <div class="am-cf">
              <?php echo '共' .$total.' 条记录';?>
              <div class="am-fr">
                <ul class="am-pagination">
                  <li class="am-disabled"><a href="#">«</a></li>
                  <li class="am-active"><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li><a href="#">»</a></li>
                </ul>
              </div>
            </div>
            <hr>
          </form>
        </div>

      </div>
    </div>
	</body>
</html>
