<?php 
class chome extends ccore{
	
	public function index(){
		$this->load("vhome");
	}
	public function showallmenu(){
		$tabel = "proc_mstr_menu";
		$fild  = "distinct(Group_menu)";
		$usernya ="#";
		if(isset($_COOKIE['access']) && !empty($_COOKIE['iduser'])){
			$usernya = $_COOKIE['iduser'];
		}
		$wheer = "userid like '%".$usernya."%'";
		$qk = $this->fpdo->select($tabel,$fild,$wheer);
		print_r($qk);
		//echo $this->fpdo->result;
		foreach (json_decode($qk,true) as $valuerow){
		echo "<div class='accordion-group'>
			<div class='accordion-heading'>
				<a class='accordion-toggle' data-toggle='collapse' data-parent='#leftMenu' href='#".$valuerow['Group_menu']."'>
					<i class='glyphicon glyphicon-tasks'></i>&nbsp&nbsp&nbsp".$valuerow['Group_menu']."
				</a>
			</div>
			<div id='".$valuerow['Group_menu']."' class='accordion-body collapse' style='height:0px; '>
				<div class='accordion-inner'>
					<ul style='display:block;'>";
					$tabel = "proc_mstr_menu";
					$fild  = "Link_page,Name_menu";
					$where = "Group_menu='".$valuerow['Group_menu']."' and userid like '%".$usernya."%'";
					$order = "Name_menu";
					$this->fpdo->select($tabel,$fild,$where,$order);
					foreach (json_decode($this->fpdo->result,true) as $valuerow){
						echo "<li style='list-style:none;'><a href='".$valuerow['Link_page']."'>
						<i class='fa fa-angle-double-right'>".$valuerow['Name_menu']."</i></a></li>";
					}
				echo "</ul>                 
				</div>
			 </div>
		 </div>";
		 }
	}
	public function showallmenuajax(){
		$tabel = "proc_mstr_menu";
		$fild  = "distinct(Group_menu)";
		$this->fpdo->select($tabel,$fild);
		foreach (json_decode($this->fpdo->getResult(),true) as $valuerow){
		echo "<li class='treeview'>
			<a href='#'>
                <i class='fa fa-edit'></i>
                <span>".$valuerow['Group_menu']."</span>
                <i class='fa fa-angle-left pull-right'></i>
            </a>
			<ul id='".$valuerow['Group_menu']."' class='treeview-menu'>";
				$tabel = "proc_mstr_menu";
				$fild  = "Link_page,Name_menu";
				$where = "Group_menu='".$valuerow['Group_menu']."'";
				$this->fpdo->select($tabel,$fild,$where);
				foreach (json_decode($db->getResult(),true) as $valuerow){
					echo "<li style='list-style:none;'><a href='".$valuerow['Link_page']."'>
					<i class='fa fa-angle-double-right'></i>".$valuerow['Name_menu']."</a></li>";
				}
		echo "</ul>     
		 </li>";
		}
	}
	public function showkeymenu($keyword){
		$usernya ="#";
		if(isset($_COOKIE['access']) && !empty($_COOKIE['iduser'])){
			$usernya = $_COOKIE['iduser'];
		}
		$key="";
		if (isset($keyword['key']))$key = $keyword['key']; else $key="";
		$tabel = "proc_mstr_menu";
		$fild  = "Code_menu,Name_menu";
		$where = "(Name_menu like '%".$key."%' or Code_menu like '".$key."') and userid like '%".$usernya."%'";
		echo "<ul style='display:block;'>";
			$this->fpdo->select($tabel,$fild,$where);
			foreach (json_decode($this->fpdo->getResult(),true) as $valuerow){
				echo "<li style='list-style:none;'><a href=\"javascript:HContentload('".$valuerow['Code_menu']."')\">
				<i class='fa fa-angle-double-right'></i>".$valuerow['Name_menu']."</a></li>";
			}
		echo "</ul>";
	}
}
?>