<div class="row">
	<div class="col-md-12">
		<div class="title-list-undian">
			<u>Silahkan pilihan program undian yang akan diproses :</u>
		</div>
		<div class="row">
			<ul class="list-undian">
			<?php 
			$data = db_query2list("SELECT * FROM project WHERE user_created = '".$_SESSION['undian_login']->id_user."' order by date_created DESC");
			if (empty($data)) {
				echo '<li style="display: block;margin: auto;height: auto;padding: 30px 10px;color: #F00;text-align: center;background: none;font-weight: bold;">Data Kosong, Silahkan hubungi administrator.</li>';
			}else{
				foreach ($data as $key => $value) {
					echo '<li><a class="list" href="'.url('undian/view/'.$value->id_project).'"><i class="fa fa-cube"></i><br>'.$value->name_project.'</a></li>';
				}
			}
			?>
			</ul>
		</div>
	</div>
</div>