<?php 
$cssAnsScriptFilesModule = array(
	'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.css',
	'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/wysiwyg-color.css',
	'/plugins/bootstrap-datetimepicker/css/datetimepicker.css',
	'/plugins/x-editable/css/bootstrap-editable.css',
	'/plugins/select2/select2.css',
	//X-editable...
	'/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js' , 
	'/plugins/x-editable/js/bootstrap-editable.js' , 
	'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.min.js' , 
	'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5.js' , 
	'/plugins/wysihtml5/wysihtml5.js',
	'/plugins/moment/min/moment.min.js',
	'/plugins/jquery.scrollTo/jquery.scrollTo.min.js',
	'/plugins/ScrollToFixed/jquery-scrolltofixed-min.js',
	'/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
	'/plugins/jquery.appear/jquery.appear.js',
	'/plugins/jquery.elastic/elastic.js',
	'/plugins/select2/select2.css',
	'/plugins/select2/select2.min.js',
	'/plugins/underscore-master/underscore.js',
	'/plugins/jquery-mentions-input-master/jquery.mentionsInput.js',
	'/plugins/jquery-mentions-input-master/jquery.mentionsInput.css',
	'/plugins/jquery-mentions-input-master/lib/jquery.events.input.js'
);
HtmlHelper::registerCssAndScriptsFiles( $cssAnsScriptFilesModule ,Yii::app()->theme->baseUrl."/assets");
$cs = Yii::app()->getClientScript();

$cssAnsScriptFilesModule = array(
	'/css/news/index.css',	
	'/js/news/index.js',
	'/js/news/newsHtml.js',
	'/css/news/newsSV.css'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
?>	
	<!-- start: PAGE CONTENT -->

<?php 
	if($type != City::CONTROLLER)
	$this->renderPartial('../pod/headerEntity', array("entity"=>$parent, "type" => $type, "viewer" => @$viewer)); 
?>

<?php 
	$viewer = isset($_GET["viewer"]) ? true : false;
	$contextName = "";
	$contextIcon = "bookmark fa-rotate-270";
	$contextTitle = "";
	$imgProfil = $this->module->assetsUrl . "/images/news/profile_default_l.png"; 
	if( isset($type) && $type == Organization::COLLECTION && isset($parent) ){
		Menu::organization( $parent );
		//$thisOrga = Organization::getById($parent["_id"]);
		$contextName = addslashes($parent["name"]);
		$contextIcon = "users";
		$contextTitle = Yii::t("common","Participants");
		$restricted = Yii::t("common","Visible to all on this wall and published on community's network");
		$titleRestricted = "Restreint";
		$private = Yii::t("common","Visible only to the members"); 
		$titlePrivate = "Privé";
		$scopeBegin= ucfirst(Yii::t("common", "private"));	
		$iconBegin= "lock";
		$headerName= "Journal de l'organisation";//.$contextName;
		$topTitle= "Journal de l'organisation";//.$contextName;
	}
	else if((isset($type) && $type == Person::COLLECTION) || (isset($parent) && !@$type)){
		if(@$viewer || !@Yii::app()->session["userId"] || (Yii::app()->session["userId"] !=$contextParentId)){
			//Visible de tous sur
			Menu::person($parent);
		
			$contextName =addslashes($parent["name"]);
			$contextIcon = "<i class='fa fa-circle text-yellow'></i> <i class='fa fa-user text-dark'></i> ";
			$contextTitle =  Yii::t("common", "DIRECTORY of")." ".$contextName;
			if(@Yii::app()->session["userId"] && $contextParentId==Yii::app()->session["userId"]){
				$restricted = Yii::t("common","Visible to all");
				$private = Yii::t("common","Visible only to me");
			}	
			if(Yii::app()->session["userId"] ==$contextParentId){
				$headerName= "Mon journal";
				$topTitle = $headerName;
			}else{
				$headerName= "Journal de : ".$contextName;
				$topTitle = $headerName;
			}
		}
		else{
			$shortName=explode(" ", $parent["name"]);
			//$headerName= "Bonjour <span class='text-red'>".addslashes($shortName[0])."</span>, l'actu de votre réseau";
			$headerName= "L'actu de votre réseau";
			$restricted = Yii::t("common","Visible to all on my wall and published on my network");
			$private = Yii::t("common","Visible only to me");
		}
		$scopeBegin= ucfirst(Yii::t("common", "my network"));	
		$iconBegin= "connectdevelop";
	}
	else if( isset($type) && $type == Project::COLLECTION && isset($parent) ){
		Menu::project( $parent );
		$contextName = addslashes($parent["name"]);
		$contextIcon = "lightbulb-o";
		$contextTitle = Yii::t("common", "Contributors of project");
		$restricted = Yii::t("common","Visible to all on this wall and published on community's network");
		$private = Yii::t("common","Visible only to the project's contributors"); 
		$scopeBegin= ucfirst(Yii::t("common", "private"));	
		$iconBegin= "lock";
		$headerName= "Journal du projet";//.$contextName;
		$topTitle = "Journal du projet";//.$contextName;
	}else if( isset($type) && $type == Event::COLLECTION && isset($parent) ){
		Menu::event( $parent );
		$contextName = addslashes($parent["name"]);
		$contextIcon = "calendar";
		$contextTitle = Yii::t("common", "Contributors of event");
		$restricted = Yii::t("common","Visible to all on this wall and published on community's network");
		$scopeBegin= ucfirst(Yii::t("common", "my network"));	
		$iconBegin= "connectdevelop";
		$headerName= "Journal de l'événement";//.$contextName;
		$topTitle = "Journal de l'événement";//.$contextName;
	}

	else if( isset($type) && $type == City::COLLECTION && isset($city) ){
		$contextName = Yii::t("common","City")." : ".$city["name"];
		$contextIcon = "university";
		$contextTitle = Yii::t("common", "DIRECTORY Local network of")." ".$city["name"];
		$scopeBegin= "Public";	
		$iconBegin= "globe";
		$headerName= "Actualités de ".$city["name"];
		$topTitle = ""; //$headerName;
	}
	else if( isset($type) && $type == "pixels"){
		//$contextName = "<i class='fa fa-rss'></i> Signaler un bug";
		//$contextTitle = Yii::t("common", "Contributors of project");
		$headerName= " Signaler un bug";
	}

	$imgProfil = "";
	if($contextParentType != "city"){
		Menu::news($type);
		$this->renderPartial('../default/panels/toolbar'); 
	}
?>
<style>
	.tools_bar{
		    border-bottom: 1px solid #E6E8E8;
	}
	.tools_bar .btn{
		    border-right: 1px solid #E6E8E8;
	}
	.mosaicflow__column {
    float:left;
    }
.mosaicflow__item img {
    display:block;
    width:100%;
    height:auto;
}
.grayscale{
	filter: grayscale(0.7) blur(1px);
	-webkit-filter: grayscale(0.7) blur(1px);
	-moz-filter: grayscale(0.7) blur(1px);
	-o-filter: grayscale(0.7) blur(1px);
	-ms-filter: grayscale(0.7) blur(1px);
}
.newImageAlbum{
	width: 75px;
    height: 75px;
    margin: 5px;
    text-align: -webkit-center;
    position: relative;
    background-color: white;
    display: inline-block;
}
.spinner-add-image{
	position: absolute;
    z-index: 10;
    left: 20px;
    top: 20px;
}
.removeImage{
	position: absolute;
    z-index: 10;
    right: 0px;
	top: 0px;
	text-shadow: 0px 0px 2px black;
}
.thumb_sel .prev_thumb {
	background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat -50px 0px;
	background-color: rgba(250,250,250,0.5);
	float: left;
	width: 26px;
	height: 22px;
	cursor: hand;
	cursor: pointer;
}
.thumb_sel .prev_thumb:hover {
	background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat 0px 0px;
}
.thumb_sel .next_thumb {
	background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat -76px 0px;
	background-color: rgba(250,250,250,0.5);
	float: left;
	width: 24px;
	height: 22px;
	cursor: hand; 
	cursor: pointer;
}
.thumb_sel .next_thumb:hover {
	background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat -26px 0px;
}
#dropdown_search{
	display:none;
    border: 1px solid #eee;
    max-height: 160px;
    overflow-y: auto;
    position: relative;
}
#dropdown_search .li-dropdown-scope{
	text-align: left;
	width:100%;
}
#dropdown_search .li-dropdown-scope a{
	font-size:12px;
	    line-height: 25px;
}
/*.results{
	margin-top: 10px;
}*/

.timeline_element .timeline_text{
	font-size:14px !important;
}
.timeline_element .img-responsive{
	max-height:300px !important;
}
#form-news{
	display: inline-block;
    width: 100%;
    padding-bottom: 10px;
}
#btn-submit-form {
    /*right: 30px;
    position: absolute;
    bottom: 10px;*/
    position:relative;
    float: right;
}
.form-group.tagstags{
	margin-bottom:0px !important;
}
.timeline_shared_picture{
	margin-top:5px;
}
.timeline_element .tag_item_map_list {
    color: #F00;
    font-weight: 200 !important;
    font-size: 12px !important;
    cursor: pointer;
}
.main-col-search{
	min-height:1100px !important;
}
.timeline_element .label-danger {
    margin-bottom: 3px;
    display: inline-block;
}
#footerDropdown{
	position:relative;
	/*background-color: white;*/
}
.tag.bold{
	font-weight:600 !important;
}
</style>
<!--<textarea class="mention"></textarea>-->


<?php 
	//if($type != City::CONTROLLER)
	$this->renderPartial('../news/podBtnTypeNews', array("type"=>$type)); 
?>

<!-- <div id="newLiveFeedForm" class="col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom-10"></div> -->
<div id="formCreateNewsTemp" style="float: none;display:none;" class="center-block">
	<div class='no-padding form-create-news-container'>

	<?php if(false) { ?>
		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px; margin-bottom: 10px; margin-left: 0px;padding: 0px 10px;"  id="list_type_news">
		  
		  <div class="btn-group btn-group-sm inline-block" id="menu-type-news">
		    <button class="btn btn-default btn-type-news tooltips text-dark active" 
		    		data-toggle="tooltip" data-placement="top" title="Messages" data-type="news">
		      <i class="fa fa-check-circle-o search_news hidden"></i> <i class="fa fa-rss"></i> 
		      <span class="hidden-xs hidden-sm hidden-md">Message</span>
		    </button>
		    <button class="btn btn-default btn-type-news tooltips text-dark" 
		    		data-toggle="tooltip" data-placement="top" title="Idée" data-type="idea">
		      <i class="fa fa-circle-o search_organizations hidden"></i> <i class="fa fa-info-circle"></i> 
		      <span class="hidden-xs hidden-sm hidden-md">Idée</span>
		    </button>
		    <button class="btn btn-default btn-type-news tooltips text-dark" 
		    		data-toggle="tooltip" data-placement="top" title="Question" data-type="question">
		      <i class="fa fa-circle-o search_projects hidden"></i> <i class="fa fa-question-circle"></i> 
		      <span class="hidden-xs hidden-sm hidden-md">Question</span>
		    </button>
		    <button class="btn btn-default btn-type-news tooltips text-dark" 
		    		data-toggle="tooltip" data-placement="top" title="Annonce" data-type="announce">
		      <i class="fa fa-circle-o search_events hidden"></i> <i class="fa fa-ticket"></i> 
		      <span class="hidden-xs hidden-sm hidden-md">Annonce</span>
		    </button>
		    <button class="btn btn-default btn-type-news tooltips text-dark" 
		    		data-toggle="tooltip" data-placement="top" title="Information" data-type="information">
		      <i class="fa fa-circle-o search_needs hidden"></i> <i class="fa fa-newspaper-o"></i> 
		      <span class="hidden-xs hidden-sm hidden-md">Information</span>
		    </button>
		  </div>

		</div>
	<?php } ?>

		<h5 class='padding-10 partition-light no-margin text-left header-form-create-news' style="margin-bottom:-40px !important;"><i class='fa fa-angle-down'></i> <i class="fa fa-file-text-o"></i> <?php echo "Rédiger un message"; //Yii::t("news","Share a thought, an idea, a link",null,Yii::app()->controller->module->id) ?> 
		<a class="btn btn-xs pull-right" style="margin-top: -4px;" onclick="javasctipt:showFormBlock(false);">
			<i class="fa fa-times"></i>
		</a>
		</h5>
		<div class="tools_bar bg-white">
			<div class="user-image-buttons">
				<form method="post" id="photoAddNews" enctype="multipart/form-data">
					<span class="btn btn-white btn-file fileupload-new btn-sm"  <?php if (!$authorizedToStock){ ?> onclick="addMoreSpace();" <?php } ?>><span class="fileupload-new"><i class="fa fa-picture-o fa-x"></i> </span>
						<?php if ($authorizedToStock){ ?>
							<input type="file" accept=".gif, .jpg, .png" name="newsImage" id="addImage" onchange="showMyImage(this);">
						<?php } ?>
						
					</span>
				</form>
			</div>
		</div>
		<form id='form-news'>
			
			<input type="hidden" id="parentId" name="parentId" value="<?php if($contextParentType != "city") echo $contextParentId; else echo Yii::app()->session["userId"]; ?>"/>
			<input type="hidden" id="parentType" name="parentType" value="<?php if($contextParentType != "city") echo $contextParentType; else echo Person::COLLECTION; ?>"/> 
			
			<input type="hidden" id="typeNews" name="type" value="news"/>

			<input 	type="text" id="falseInput" onclick="javascript:showFormBlock(true);" 
					class="col-sm-12 col-xs-12 col-md-12" placeholder="Exprimez-vous ..."   style="padding:15px;"/>

			<div class="extract_url">
				<div class="padding-10 bg-white">
					<img id="loading_indicator" src="<?php echo $this->module->assetsUrl ?>/images/news/ajax-loader.gif">
					<textarea id="get_url" placeholder="Exprimez-vous ..." class=" get_url_input form-control textarea mention" style="border:none;background:transparent !important" name="getUrl" spellcheck="false" ></textarea>
					<ul class="dropdown-menu" id="dropdown_search" style="">
					</ul>

					<div id="results" class="bg-white results"></div>
				</div>
			</div>
			<div class="form-group tagstags" style="">
			    <input id="tags" type="" data-type="select2" name="tags" placeholder="#Tags" value="" style="width:100%;">		    
			</div>
			<div class="form-actions no-padding" style="display: block;">
				
				<div class="list_tags_scopes col-md-9 no-padding margin-bottom-10"></div>

				<?php if((@$canManageNews && $canManageNews==true) 
							|| (@Yii::app()->session["userId"] 
							&& $contextParentType==Person::COLLECTION 
							&& Yii::app()->session["userId"]==$contextParentId)){ ?>
				
				<!--<div id="tagScopeListContainer" class="list_tags_scopes col-md-12 col-sm-12 col-xs-12 no-padding"></div>
				<input type="hidden" name="scope" value="public"/>-->
				
				<div class="dropdown col-md-9">
					<a data-toggle="dropdown" class="btn btn-default" id="btn-toogle-dropdown-scope" href="#"><i class="fa fa-<?php echo $iconBegin ?>"></i> <?php echo $scopeBegin ?> <i class="fa fa-caret-down" style="font-size:inherit;"></i></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
						<?php if (@$private && ($contextParentType==Project::COLLECTION || $contextParentType==Organization::COLLECTION)){ ?>
						<li>
							<a href="javascript:;" id="scope-my-network" class="scopeShare" data-value="private"><h4 class="list-group-item-heading"><i class="fa fa-lock"></i> <?php echo ucfirst(Yii::t("common", "private")) ?></h4>
								<p class="list-group-item-text small"><?php echo $private ?></p>
							</a>
						</li>
						<?php } ?>
						<?php if(@$restricted){ ?>
							<li>
							<a href="javascript:;" id="scope-my-network" class="scopeShare" data-value="restricted"><h4 class="list-group-item-heading"><i class="fa fa-connectdevelop"></i> <?php echo ucfirst(Yii::t("common", "my network")) ?></h4>
								<p class="list-group-item-text small"><?php echo $restricted ?></p>
							</a>
						</li>
						<?php } ?>
						<?php if(false){ ?>
						<li>
							<a href="javascript:;" id="scope-my-wall" class="scopeShare" data-value="public"><h4 class="list-group-item-heading"><i class="fa fa-globe"></i> <?php echo ucfirst(Yii::t("common", "public")) ?></h4>
								<!--<div class="small" style="padding-left:12px;">-->
							<p class="list-group-item-text small"><?php echo Yii::t("common","Visible to all and posted on the city's wall")?></p>
							</a>
						</li>
						<?php } ?>
						<?php if (@$private && $contextParentType==Person::COLLECTION){ ?>
						<li>
							<a href="javascript:;" id="scope-my-network" class="scopeShare" data-value="private"><h4 class="list-group-item-heading"><i class="fa fa-lock"></i> <?php echo ucfirst(Yii::t("common", "private")) ?></h4>
								<p class="list-group-item-text small"><?php echo $private ?></p>
							</a>
						</li>
						<?php } ?>
						<!--<li>
							<a href="#" id="scope-select" data-toggle="modal" data-target="#modal-scope"><i class="fa fa-plus"></i> Selectionner</a>
						</li>-->
					</ul>
				</div>		
				<?php } ?>

				<?php if($type=="city"){ ?>
					<?php /* ?>
					<input type="hidden" name="cityInsee" value=""/>
					<input type="hidden" id="cityPostalCode" name="cityPostalCode" value=""/>
					<p class="text-xs hidden-xs" style="position:absolute;bottom:20px;"><?php echo Yii::t("news","News sent to") ?>:</p> 
					<div class="badge cityBadge" style="position:absolute;bottom:10px;">
					</div><?php */ ?>
					<input type="hidden" name="scope" value="public"/>
				<?php } ?>
									
				
				<?php if((@$canManageNews && $canManageNews=="true") || (
						@Yii::app()->session["userId"] && 
						$contextParentType==Person::COLLECTION && Yii::app()->session["userId"]==$contextParentId)){ ?>
				
						<?php if($contextParentType==Organization::COLLECTION || $contextParentType==Project::COLLECTION){ ?>
							<input type="hidden" name="scope" value="private"/>
						<?php } else if($contextParentType==Event::COLLECTION || $contextParentType==Person::COLLECTION){ ?>
							<input type="hidden" name="scope" value="restricted"/>
						<?php } else { ?>
						<input type="hidden" name="scope" value="public"/>
						<?php } ?>

				<?php }else{ if($contextParentType==Event::COLLECTION){?>
					
					<input type="hidden" name="scope" value="restricted"/>

				<?php } else { ?>

					<input type="hidden" name="scope" value="private"/>

				<?php } } ?>
				<div class="row col-md-3 pull-right">
					<button id="btn-submit-form" type="submit" class="btn btn-green">Envoyer <i class="fa fa-arrow-circle-right"></i></button>
				</div>
			</div>
		</form>
	 </div>
</div>


<?php if( !isset( Yii::app()->session['userId'] ) ) { ?>
<div class="alert col-md-11 col-xs-12 center" style="margin-bottom: 0px; margin-top: 0px; ">
  <div class="col-md-12 margin-bottom-10"><i class="fa fa-info-circle"></i> Vous devez être connecté pour publier du contenu.</div>
  <!-- <button class="btn-top btn btn-success" onclick="showPanel('box-register');"><i class="fa fa-plus-circle"></i> <span class="hidden-xs">S'inscrire</span></button>
  <button class="btn-top btn bg-red" style="margin-right:10px;" onclick="showPanel('box-login');"><i class="fa fa-sign-in"></i> <span class="hidden-xs">Se connecter</span></button>  -->
</div>
<?php } ?>

<div id="newsHistory" class="padding-10">
	<!--<div class="margin-top-10">
		<button class="btn text-red btn-default" id="btn-filter-tag-news" onclick="toggleFilters('#tagFilters');"># Rechercher par tag</button>
		<button class="btn text-red btn-default" id="btn-filter-scope-news" onclick="toggleFilters('#scopeFilters');"><i class="fa fa-circle-o"></i> Rechercher par lieu</button>
		<button class="btn btn-sm btn-default bg-red" onclick="showAllNews();"><i class="fa fa-times"></i> Annuler</button>
	</div>-->
	<div class="col-md-11 no-padding">
		<!-- start: TIMELINE PANEL -->
		<div class="no-padding panel panel-white" style="padding-top:10px;box-shadow:inherit;">
			<div id="top" class="no-padding panel-body panel-white">
				<div id="tagFilters" class="optionFilter pull-left center col-md-10" style="display:none;" ></div>
				<div id="scopeFilters" class="optionFilter pull-left center col-md-10" style="display:none;" ></div>
	
				<div id="timeline" class="col-md-12">
					<div class="timeline">
						<div class="newsTL">
							<div class="spine"></div>
						</div>
					</div>
				</div>
				<ul class="timeline-scrubber inner-element newsTLmonthsList col-md-2"></ul>
			</div>
			<div class="stream-processing center">
				<span class="search-loader text-dark" style="font-size:20px;"><i class="fa fa-circle-o-notch fa-spin"></i></span>
			</div>
		</div>
		<!-- end: TIMELINE PANEL -->
	</div>
</div>

<div id="modal_scope_extern" class="form-create-news-container hide"></div>


<?php 
foreach($news as $key => $oneNews){
	if(@$news[$key]["type"] && $news[$key]["type"] != "activityStream")
		$news[$key]["typeSig"] = $news[$key]["type"];
	//else
		//$news[$key]["typeSig"] = "news";	
}
?>

<!-- end: PAGE CONTENT-->
<script type="text/javascript">
/*
	Global Variables to initiate timeline
	- offset => represents measure of last newsFeed (element for each stream) to know when launch loadStrean
	- lastOffset => avoid repetition of scrolling event (unstable behavior)
	- dateLimit => date to know until when get new news
*/
<?php if(@$viewer){ ?>
	viewer="<?php echo $viewer ?>";
<?php } else{ ?>
	viewer="";
<?php } ?>

<?php if (@$news && !empty($news)){ ?>
var news = <?php echo json_encode(@$news)?>;
<?php }else { ?>
var news = "";
<?php } ?>
var parent = <?php echo json_encode(@$parent)?>;

var newsReferror={
		"news":{
			"offset":"",
			"dateLimit":0,
			"lastOffset":""
			},
		"activity":{
			"offset":"",
			"dateLimit":0,
			"lastOffset":""
			},
	};
var mode = "view";
var canPostNews = <?php echo json_encode(@$canPostNews) ?>;
var canManageNews = <?php echo json_encode(@$canManageNews) ?>;
var idSession = "<?php echo Yii::app()->session["userId"] ?>";
var contextParentType = <?php echo json_encode(@$contextParentType) ?>;
var contextParentId = <?php echo json_encode(@$contextParentId) ?>;
var countEntries = 0;
var offset="";
var	dateLimit = 0;	
var lastOffset="";
var streamType="news";
var months = ["<?php echo Yii::t('common','january') ?>", "<?php echo Yii::t('common','febuary') ?>", "<?php echo Yii::t('common','march') ?>", "<?php echo Yii::t('common','april') ?>", "<?php echo Yii::t('common','may') ?>", "<?php echo Yii::t('common','june') ?>", "<?php echo Yii::t('common','july') ?>", "<?php echo Yii::t('common','august') ?>", "<?php echo Yii::t('common','september') ?>", "<?php echo Yii::t('common','october') ?>", "<?php echo Yii::t('common','november') ?>", "<?php echo Yii::t('common','december') ?>"];
var contextMap = {
	"tags" : [],
	"scopes" : {
		codeInsee : [],
		codePostal : [], 
		region :[],
		addressLocality : []
	},
};
var formCreateNews;
var indexStep = 5;
var currentIndexMin = 0;
var currentIndexMax = indexStep;
var currentMonth = null;
var scrollEnd = false;
var totalEntries = 0;
var timeout = null;
var tagsFilterListHTML = "";
var scopesFilterListHTML = "";
var loadingData = false;
var initLimitDate = <?php echo json_encode(@$limitDate) ?>;
var docType="<?php echo Document::DOC_TYPE_IMAGE; ?>";
var contentKey = "<?php echo Document::IMG_SLIDER; ?>";
var uploadUrl = "<?php echo Yii::app()->params['uploadUrl'] ?>";
var locality = "<?php echo @$locality ?>";
var searchBy = "<?php echo @$searchBy ?>";
var tagSearch = "<?php //echo @$tagSearch ?>";
var peopleReference=false;
var mentionsContact = [];
jQuery(document).ready(function() 
{
//	console.log(dataNewsSearch);
	if(location.hash.indexOf("#default.live") == 0){//contextParentType=="city"){
		//$("#cityInsee").val(inseeCommunexion);
		//$("#cityPostalCode").val(cpCommunexion);
		$(".cityBadge").html("<i class=\"fa fa-university\"></i> "+cpCommunexion);
	}else{
		$(".list_tags_scopes").addClass("tagOnly");
	}
	//canManageNews="";
	//Modif SBAR
	//$(".my-main-container").off(); 
	if(contextParentType=="pixels"){
		tagsNews=["bug","idea"];
	}
	else {
		tagsNews = <?php echo json_encode($tags); ?>
	}
	/////// A réintégrer pour la version last
	var $scrollElement = $(".my-main-container");

	
	$('#tags').select2({tags:tagsNews});
	$("#tags").select2('val', "");
	if(contextParentType != "city")

	smoothScroll('0px');
	<?php if(@$topTitle != ""){ ?>
	setTitle("<?php echo @$headerName; ?>","rss", "<?php echo @$topTitle; ?>");
	<?php } ?>
	//<span class='text-red'><i class='fa fa-rss'></i> Fil d'actus de</span>
	//if(contextParentType!="city"){
		
		//if(contextParentId == idSession)
		/*$(".moduleLabel").html("<i class='fa fa-rss'></i> Mon fil d'actus" + 
								"<img class='img-profil-parent' src='<?php echo $imgProfil; ?>'>");
		else
		$(".moduleLabel").html("<span class='text-red'><i class='fa fa-rss'></i> Fil d'actus de</span> <?php echo addslashes(@$contextName); ?>" + 
								"<img class='img-profil-parent' src='<?php echo $imgProfil; ?>'>");*/
		
		
	/*}else{
		
	}*/
	
	// SetTimeout => Problem of sequence in js script reader
	setTimeout(function(){
		//loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep);
		buildTimeLine (news, 0, indexStep);
		bindTags();
		//console.log(news);
		if(typeof(initLimitDate.created) == "object")
			dateLimit=initLimitDate.created.sec;
		else
			dateLimit=initLimitDate.created;
		
		$(".my-main-container").bind("scroll",function(){ //console.log(loadingData, scrollEnd);
		    if(!loadingData && !scrollEnd){
		          var heightContainer = $(".my-main-container")[0].scrollHeight;
		          if(isLiveGlobal()){
		          	heightContainer = $("#timeline").height(); console.log("heightContainer", heightContainer);
		          }
		          var heightWindow = $(window).height();
		          if( ($(this).scrollTop() + heightWindow) >= heightContainer - 200){
		            console.log("scroll in news/index MAX");
		            loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep);
		          }
		    }
		});
		$('.tooltips').tooltip();
	},100);
	getUrlContent();
	
	setTimeout(function(){
		$("#btn-submit-form").on("click",function(){
			saveNews();
		});
	},500);

	
	//Sig.restartMap();
	//Sig.showMapElements(Sig.map, news);
	initFormImages();
	if(myContacts != null){
		$.each(myContacts["people"], function (key,value){
			avatar="";
		  	if(value.profilThumbImageUrl!="")
				avatar = baseUrl+value.profilThumbImageUrl;
		  	object = new Object;
		  	object.id = value._id.$id;
		  	object.name = value.name;
			object.avatar = avatar;
			object.type = "citoyens";
			mentionsContact.push(object);
	  	});
	  	$.each(myContacts["organizations"], function (key,value){
		  	avatar="";
		  	if(value.profilThumbImageUrl!="")
				avatar = baseUrl+value.profilThumbImageUrl;
		  	object = new Object;
		  	object.id = value._id.$id;
		  	object.name = value.name;
			object.avatar = avatar;
			object.type = "organizations";
			mentionsContact.push(object);
	  	});
	}
	$('textarea.mention').mentionsInput({
	  onDataRequest:function (mode, query, callback) {
		  	var data = mentionsContact;
		  	data = _.filter(data, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 });
			callback.call(this, data);

	   		var search = {"search" : query};
	  		$.ajax({
				type: "POST",
		        url: baseUrl+"/"+moduleId+"/search/searchmemberautocomplete",
		        data: search,
		        dataType: "json",
		        success: function(retdata){
		        	if(!retdata){
		        		toastr.error(retdata.content);
		        	}else{
			        	//console.log(retdata);
			        	data = [];
			        	for(var key in retdata){
				        	for (var id in retdata[key]){
					        	avatar="";
					        	if(retdata[key][id].profilThumbImageUrl!="")
					        		avatar = baseUrl+retdata[key][id].profilThumbImageUrl;
					        	object = new Object;
					        	object.id = id;
					        	object.name = retdata[key][id].name;
					        	object.avatar = avatar;
					        	object.type = key;
					        	var findInLocal = _.findWhere(mentionsContact, {
									name: retdata[key][id].name, 
									type: key
								}); 
								if(typeof(findInLocal) == "undefined")
									mentionsContact.push(object);
					 			}
			        	}
			        	data=mentionsContact;
			        	//console.log(data);
			    		data = _.filter(data, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 });
						callback.call(this, data);
						console.log(callback);
		  			}
				}	
			})
	  }
  	});

   	//Construct the first NewsForm
	//buildDynForm();
	//déplace la modal scope à l'exterieur du formulaire


 	$('#modal-scope').appendTo("#modal_scope_extern") ;
 	
 	showTagsScopesMin(".list_tags_scopes");
 	showFormBlock(false);
});
function isInArray(value, array) {
  return array.indexOf(value) > -1;
}


</script>
