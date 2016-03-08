<?php
$cs = Yii::app()->getClientScript();
//if(!Yii::app()->request->isAjaxRequest)
//{
	$cssAnsScriptFilesModule = array(
		'/assets/plugins/jsonview/jquery.jsonview.js',
		'/assets/plugins/jsonview/jquery.jsonview.css',
		'/assets/js/sig/geoloc.js',
		'/assets/js/dataHelpers.js',
		//'/plugins/DataTables/media/css/DT_bootstrap.css',
		//'/plugins/DataTables/media/js/jquery.dataTables.min.1.10.4.js',
    	//'/plugins/DataTables/media/js/DT_bootstrap.js'
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule);
//}

$userId = Yii::app()->session["userId"] ;
?>
<div class="panel panel-white">
	<div id="config">
		<div class="panel-heading border-light">
			<h4 class="panel-title">Import Data</h4>
		</div>
		<div class="panel-body">
			<!--<form id="formfile" method="POST" action="<?php //echo Yii::app()->getRequest()->getBaseUrl(true).'/communecter/admin/importData';?>" enctype="multipart/form-data"> -->
				<div class="col-sm-12 col-xs-12 rows">
					<div class="col-sm-3 col-xs-12">
						<label for="chooseCollection">Collection : </label>
						<?php
							$params = array();
							$fields = array("_id", "key");
							$listCollection = Import::getMicroFormats($params, $fields);
						?>
						<select id="chooseCollection" name="chooseCollection">
							<option value="-1">Choisir</option>
							<?php
								foreach ($listCollection as $key => $value) {
									echo '<option value="'.$value['_id']->{'$id'}.'">'.$value['key'].'</option>';
								}
							?>
						</select>
					</div>
					<div class="col-sm-3 col-xs-12">
						<select id="selectTypeData" name="selectTypeData">
							<option value="-1">Choisir</option>
							<option value="url">URL</option>
							<option value="file">File</option>
						</select>
					</div>
				</div>
				<div class="col-sm-12 col-xs-12 rows">
					<div id="divFile">
						<div class="col-sm-3 col-xs-12">
							<label for="fileImport">Fichier (CSV,JSON) :</label>
							<input type="file" id="fileImport" name="fileImport" accept=".csv,.json,.js">
						</div>
						<div class="col-sm-3 col-xs-12">
							<label> Séparateur de données :</label>
							<select id="separateurDonnees" name="separateurDonnees">
								<option value=";">point-virgule</option>
							  	<option value=",">virgule</option>
							  	<option value=".">point</option>
							  	<option value=" ">espace</option>
							</select>
						</div>
						<div class="col-sm-3 col-xs-12">
							<label> Séparateur de texte :</label>
							<select id="separateurTexte" name="separateurTexte">
								<option value='"'>guillemet</option>
							  	<option value="'">cote</option>
							</select>
						</div>
					</div>
					<div id="divUrl">
						<div class="col-sm-12 col-xs-12">
							<label for="textUrl">URL (format JSON):</label>
							<input type="text" id="textUrl" name="textUrl" value="">
						</div>
						<div class="col-sm-12 col-xs-12">
							<label for="textUrl">Path Object :</label>
							<input type="text" id="pathObject" name="pathObject" value="">
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">
					<div class="form-group col-sm-2 col-sm-offset-5">
						<a href="#" id="btnVerification" class="btn btn-primary col-sm-12">Vérification</a>
					</div>
				</div>
			<!--</form>-->
		</div>
	</div>
	<div id="createLink">
		<div class="panel-heading border-light">
			<h4 class="panel-title">Assignation des données</h4>
		</div>
		<div class="panel-body">
			<!--<div class="col-sm-12 col-xs-12">
				<label for="subFile">Fichier : </label>
				<select id="subFile">
					
				</select>
				
			</div>

			
			<br/> <br/> -->
			
			<div class="col-sm-12 col-xs-12">
				
				<!--<div id="divSearchMember">
					<div class="col-sm-3 col-xs-12">
						<input class="invite-search form-control" placeholder="Choisir une personne qui sera relié au données" autocomplete = "off" id="inviteSearch" name="inviteSearch" value="">
			        		<ul class="dropdown-menu" id="dropdown_searchInvite" style="">
								<li class="li-dropdown-scope">-</li>
							</ul>
						</input>
						<input type="hidden" name="memberId" id="memberId" value=""/>
					</div>
					<div class="col-sm-4 col-xs-12">
						People : <div id="namePeople"></div>
					</div>
				</div>-->
			</div>
			<div id="divtab" class="table-responsive">
				<input type="hidden" id="nbLigneMapping" value="0"/>
				<div id="divInputHidden"></div>
				<table id="tabcreatemapping" class="table table-striped table-bordered table-hover">
		    		<thead>
			    		<tr>
			    			<th class="col-sm-5">Colonne CSV</th>
			    			<th class="col-sm-5">Mapping</th>
			    			<th class="col-sm-2">Ajouter/Supprimer</th>
			    		</tr>
		    		</thead>
			    	<tbody class="directoryLines" id="bodyCreateMapping">
				    	<tr id="LineAddMapping">
			    			<td>
			    				<select id="selectHeadCSV" class="col-sm-12"></select>
			    			</td>
			    			<td>
			    				<select id="selectLinkCollection" class="col-sm-12"></select>
			    			</td>
			    			<td>
			    				<input type="submit" id="addMapping" class="btn btn-primary col-sm-12" value="Ajouter"/>
			    			</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="col-sm-6 col-xs-12">
					<label for="selectCreator">Créateur : </label>
					<select id="selectCreator">
						<option value="you">Vous-même</option>
						<option value="other">Autre</option>
					</select>
				</div>
				<div id="divSearchCreator" class="col-sm-6 col-xs-12">
						<input class="" placeholder="Saisir l'ID du creator de données" id="creatorID" name="creatorID" value="">
						<input class="" placeholder="Saisir l'Email du creator de données" id="creatorEmail" name="creatorEmail" value="">
				</div>
			</div>
			<div class="col-sm-12 col-xs-12">
				<label for="selectRole">Role : </label>
				<select id="selectRole">
					<option value="creator">Creator</option>
					<option value="admin">Admin</option>
					<option value="member">Member</option>
				</select>
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="col-sm-6 col-xs-12">
					<label for="inputKey">Key : </label>
					<input class="" placeholder="Key attribuer a l'ensemble des données importer" id="inputKey" name="inputKey" value="">
				</div>
				<div class="col-sm-6 col-xs-12">
					<label>
						Warnings : <input type="checkbox" value="" id="checkboxWarnings" name="checkboxWarnings">
					</label>
				</div>
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="col-sm-6 col-xs-12">
					<label>
						Test : <input type="checkbox" value="" id="checkboxTest" name="checkboxTest">
					</label>
				</div>
				<div class="col-sm-6 col-xs-12">
					<label for="inputNbTest">Nombre d'entités à tester max(900) : </label>
					<input class="" placeholder="" id="inputNbTest" name="inputNbTest" value="">
				</div>
			</div>
			<div class="form-group col-sm-12">
				<div class="form-group col-sm-2 col-sm-offset-5">
					<a href="#" id="btnVisualisation" class="btn btn-primary col-sm-12">Visualisation</a>
				</div>
			</div>
		</div>
	</div>
	<div id="verifBeforeImport">
		<div class="panel-heading border-light">
			<h4 class="panel-title">Vérification avant l'import</h4>
		</div>
		<div class="panel-body">
			<div class="col-xs-12 col-sm-12">
				<div class="panel-scroll row-fluid height-300">
					<table id="representation" class="table table-striped table-hover">

					</table>
				</div>
				
			</div>
			<div class="col-xs-12 col-sm-12" id="affichageJSON">
				<div class="col-xs-12 col-sm-6">
					<label>Données importés :</label>	
					<div class="panel panel-default">
						<div class="panel-body">
							<div id="divJsonImport" class="panel-scroll height-300">
								<input type="hidden" id="jsonImport" value="">
							    <div class="col-sm-12" id="divJsonImportView"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6">
					<label>Données rejetées :</label>	
					<div class="panel panel-default">
						<div class="panel-body">
							<div id="divJsonError" class="panel-scroll height-300">
								<input type="hidden" id="jsonError" value="">
							    <div class="col-sm-12" id="divJsonErrorView"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12">
				<a href="#" class="btn btn-primary col-sm-2 col-md-offset-2" type="submit" id="btnGeo">Geolocalisation</a>
				<a href="#" class="btn btn-primary col-sm-2 col-md-offset-2" type="submit" id="btnImport">Import</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">


var tabObject = [];
var file = [];
var userId = "<?php echo $userId; ?>" ; ;
var pathTmp = "<?php echo sys_get_temp_dir().'/importData/'; ?>" ;
$("#memberId").html(userId);

jQuery(document).ready(function() 
{
	

	bindEvents();
	var createLink = "<?php echo $createLink; ?>" ;

	
	if(createLink == false)
		$("#createLink").hide();
	$("#verifBeforeImport").hide();
	$("#divSearchCreator").hide();
	$("#divUrl").hide();
	$("#divFile").hide();
	//$("#representation").DataTable();

});

function bindEvents()
{

	

	$("#fileImport").change(function(e) {
    	var ext = $("input#fileImport").val().split(".").pop().toLowerCase();
    	//console.log("ext", ext, $.inArray(ext, "json"));
		if(ext != "csv" && ext !=  "json" && ext == "js") {
			alert('Upload CSV or JSON');
			return false;
		}

		if(ext == "csv") {
			if (e.target.files != undefined) {
				var reader = new FileReader();
				file = [];
				reader.onload = function(e) {
					//console.log("csv : ", e.target.result );
					var csvval=e.target.result.split("\n");
					//console.log("csv : ", csvval );
					$.each(csvval, function(key, value){
						var ligne = value.split(";");
						var newLigne = [];
						$.each(ligne, function(keyLigne, valueLigne){
							//console.log("valueLigne", valueLigne);
							if(valueLigne.charAt(0) == '"' && valueLigne.charAt(valueLigne.length-1) == '"'){
								var elt = valueLigne.substr(1,valueLigne.length-2);
								newLigne.push(elt);
							}else{
								newLigne.push(valueLigne);
							}
						});
						
		  				file.push(newLigne);
		  			});
		  			console.log("file :", file.length );
				};
				reader.readAsText(e.target.files.item(0));
			}
		}
		else if(ext == "json" || ext == "js") {
			if (e.target.files != undefined) {
				var reader = new FileReader();
				file = [];
				reader.onload = function(e) {
					//console.log("json : ", e.target.result );
					file.push(e.target.result);
		  			//console.log("file : ", file );
				};
				reader.readAsText(e.target.files.item(0));
			}
		}
		
		return false;

	});

	$("#btnVerification").off().on('click', function(e)
  	{
  		if($("#chooseCollection").val() == "-1"){
  			toastr.error("Vous devez sélectionner une collection");
  			return false ;
  		}
  		var nameF = "";
  		var idCollection = $("#chooseCollection").val();
  		var typeF = "";
  		
  		var typeDate = $("#selectTypeData").val();
  		if(typeDate == "url"){
			nameF = "JSON_URL";
  			typeF = "json";			
			$.ajax({
				url: baseUrl+'/communecter/admin/getdatabyurl/',
				type: 'POST',
				dataType: 'json', 
				data:{ url : $("#textUrl").val() },
				async : false,
				success: function (obj){
					console.log('success');
					file.push(obj.data) ;

					$.ajax({
				        type: 'POST',
				        data: {
				        		nameFile : nameF,
				        		typeFile : typeF,
				        		file : file,
				        		chooseCollection : $("#chooseCollection").val(),
				        		pathObject : $("#pathObject").val()
				        	},
				        url: baseUrl+'/communecter/admin/assigndata/',
				        dataType : 'json',
				        async : false,
				        success: function(data)
				        {
				        	console.log("btnVerification data",data.createLink);
				        	if(data.createLink){

				        		resultAssignData(data);
				        		$("#createLink").show();
				        	}
				        	else{

				        	}

				        }
					});
				},
				error: function (error) {
					console.log('error', error);
				}
			});
		}	
		else if(typeDate == "file")
		{
			var nameFile = $("#fileImport").val().split("."); 
	  		console.log("type",nameFile[nameFile.length-1]);
	  		if(nameFile[nameFile.length-1] != "csv" && nameFile[nameFile.length-1] != "json" && nameFile[nameFile.length-1] != "js" )
	  		{
	  			toastr.error("Vous devez sélectionner un fichier en CSV ou JSON");
	  			return false ;
	  		}

	  		nameF = nameFile[0];
  			typeF = nameFile[nameFile.length-1];
  			console.log("file2 :", file.length );
  			assignData2($("#chooseCollection").val(), typeF);
	  		

	  		/*var fin = false ;
	  		var indexStart = 0 ;
	  		var limit = 900 ;
	  		var indexEnd = limit;


	  		while(fin == false){
	  			subFile = file.slice(indexStart,indexEnd);
	  			//console.log("indexStart", indexStart, indexEnd);
	  			console.log("subFile", subFile.length);
	  			// Appel methode assignData
	  			assignData(subFile, typeF);

	  			// Appel methode CréationSubFile

	  			indexStart = indexEnd ;
	  			indexEnd = indexEnd + limit;

	  			if(indexStart > file.length)
	  				fin = true ;

	  		}*/
		}	
  		

		chaineInputHidden = "" ;
		chaineInputHidden += '<input type="hidden" id="idCollection" value="' + idCollection + '"/>';
		chaineInputHidden += '<input type="hidden" id="nameFile" value="'+nameF+'"/>';
		chaineInputHidden += '<input type="hidden" id="typeFile" value="'+typeF+'"/>';
		$("#divInputHidden").html(chaineInputHidden);
		return false;
  		
  	});


	$('#inviteSearch').keyup(function(e){
	    var search = $('#inviteSearch').val();
	    if(search.length>2){
	    	clearTimeout(timeout);
			timeout = setTimeout('autoCompleteInviteSearch("'+encodeURI(search)+'")', 500); 
		 }else{
		 	$("#dropdown_searchInvite").css({"display" : "none" });	
		 }	
	});



	/*$("#selectRole").change( function (){
		var role = $("#selectRole").val();
		if(role == "creator")
		{
			$("#divSearchMember").hide();
			$("#memberId").html(userId);
		}	
		else
			$("#divSearchMember").show();
	});*/

	$("#selectTypeData").change( function (){
		var typeDate = $("#selectTypeData").val();
		if(typeDate == "url")
		{
			$("#divUrl").show();
			$("#divFile").hide();
		}	
		else if(typeDate == "file")
		{
			$("#divUrl").hide();
			$("#divFile").show();
		}	
	});


	$("#selectCreator").change( function (){
		var creator = $("#selectCreator").val();
		if(creator == "you")
		{
			$("#divSearchCreator").hide();
			$("#creatorID").html(userId);
		}	
		else
		{
			$("#divSearchCreator").show();
			$("#creatorID").html("");
		}	
	});


	$("#addMapping").off().on('click', function()
  	{
  		var nbLigneMapping = parseInt($("#nbLigneMapping").val()) + 1;
  		var error = false ;
  		var msgError = "" ;

  		var selectValueHeadCSV = $("#selectHeadCSV option:selected").text() ;
  		var selectIdHeadCSV = $("#selectHeadCSV option:selected").val() ;
  		var selectLinkCollection = $("#selectLinkCollection option:selected").text() ;


  		var inc = 1;
  		while(error == false && inc <= nbLigneMapping)
  		{
  			if($("#valueHeadCSV"+inc).text() == selectValueHeadCSV )
  			{
  				error = true;
  				msgError += "Vous avez déja ajouter l'éléments de la colonne CSV. "
  			}

  			if($("#valueLinkCollection"+inc).text() == selectLinkCollection)
  			{
  				error = true;
  				msgError += "Vous avez déja ajouter l'éléments de la colonne du Mapping. "
  			}
  			inc++;
  		}

  		if(error == false)
  		{
  			var arrayLinkCollection = selectLinkCollection.split(".");
  			if(verifNameSelected(arrayLinkCollection))
  			{
  				var newOptionSelect = addNewMappingForSelecte(arrayLinkCollection, false);
	  			var arrayOption = [];
	  			getOptionHTML(arrayOption, newOptionSelect, "");
	  			verifBeforeAddSelect(arrayOption);
	  			chaine = "" ;
	  			$.each(arrayOption, function(key, value){
	  				chaine = chaine + '<option name="optionLinkCollection" values="'+value+'">'+value+'</option>'
	  			});

	  			$("#selectLinkCollection").append(chaine);
  			}

  			
	  		ligne = '<tr id="lineMapping'+nbLigneMapping+'"> ';
	  		ligne =	 ligne + '<td id="valueHeadCSV'+nbLigneMapping+'">' + selectValueHeadCSV + '</td>';
	  		ligne =	 ligne + '<td id="valueLinkCollection'+nbLigneMapping+'">' + selectLinkCollection + '</td>';
	  		ligne =	 ligne + '<td><input type="hidden" id="idHeadCSV'+nbLigneMapping+'" value="'+ selectIdHeadCSV +'"/><a href="#" class="deleteLineMapping btn btn-danger">X</a></td></tr>';
	  		$("#nbLigneMapping").val(nbLigneMapping);
	  		$("#LineAddMapping").before(ligne);
	  		bindEvents();
	  	}
	  	else
	  	{
	  		toastr.error(msgError);
	  	}

	  	bindEvents();
  		return false;
  	});

	$(".deleteLineMapping").off().on('click', function()
  	{
  		$(this).parent().parent().remove();
  	});


  	$("#btnVisualisation").off().on('click', function()
  	{
		var creator = "" ;
  		if($("#selectCreator").val() == "you")
  			creator = userId ;
  		else if($("#selectCreator").val() == "other")
  			creator = $('#creatorID').val() ;
		var nbLigneMapping = $("#nbLigneMapping").val();
		
		var infoCreateData = [] ;

		if(nbLigneMapping == 0)
		{
			$.unblockUI();
			toastr.error("Vous devez faire au moins une assignation de données");
  			return false ;
		}
		else
		{
			for (i = 1; i <= nbLigneMapping; i++) 
	  		{
	  			if($('#lineMapping'+i).length)
	  			{
	  				var valuesCreateData = {};
					valuesCreateData['valueLinkCollection'] = $("#valueLinkCollection"+i).text();
					valuesCreateData['idHeadCSV'] = $("#idHeadCSV"+i).val();
					infoCreateData.push(valuesCreateData);
	  			}
				
	  		}

	  		/*var jsonFile = "" ;

	  		if($("#typeFile").val() == "csv")
	  			jsonFile = $("#jsonCSV").val() ;
	  		else if($("#typeFile").val() == "json" || $("#typeFile").val() == "js")
	  			jsonFile = $("#jsonJSON").val() ;*/

	  		if(infoCreateData != []){	
	  			
	  			var params = {
	        		infoCreateData : infoCreateData, 
	        		idCollection : $("#idCollection").val(),
	        		nameFile : $("#nameFile").val(),
	        		typeFile : $("#typeFile").val(),
	        		role : $("#selectRole").val(),
	        		creatorID : creator,
	        		creatorEmail : $('#creatorEmail').val(),
	        		pathObject : $('#pathObject').val(),
			        key : $("#inputKey").val(),
			        warnings : $("#checkboxWarnings").is(':checked')
			    }


	  			if($("#checkboxTest").is(':checked')){
	  				if($("#typeFile").val() == "csv"){
	  					var subFile = file.slice(0,$("#inputNbTest").val());
	  					params["file"] = subFile;
	  				}
			  		else if($("#typeFile").val() == "json" || $("#typeFile").val() == "js"){
			  			params["file"] = file;
			  			params["nbTest"] = $("#inputNbTest").val();
			  		}
	  				
		  			visualisation(params);

	  			}else{

	  				if($("#typeFile").val() == "csv"){
	  					var fin = false ;
				  		var indexStart = 0 ;
				  		var limit = 900 ;
				  		var indexEnd = limit;

				  		while(fin == false){
				  			subFile = file.slice(indexStart,indexEnd);
				  			console.log("subFile", subFile.length);

				  			params["file"] = subFile;
				  			visualisation(params);

							indexStart = indexEnd ;
				  			indexEnd = indexEnd + limit;
				  			if(indexStart > file.length)
				  				fin = true ;

				  		}
	  				}
			  		else if($("#typeFile").val() == "json" || $("#typeFile").val() == "js"){
			  			params["file"] = file;
				  		visualisation(params);
			  		}
	  				
	  			}
	  		}
	  		else
			{
				toastr.error("Vous devez ajouter des éléments au mapping.");
			}
	  		console.log("infoCreateData", infoCreateData);
		}
		$.unblockUI();
  		return false;
  	});


	$("#btnImport").off().on('click', function()
  	{
  		console.log("jsonImport" , $('#jsonImport').val());
  		console.log("jsonError" , $('#jsonError').val());
  		$.ajax({
	        type: 'POST', 
	        data: { jsonImport : $('#jsonImport').val(), 
	        		jsonError : $('#jsonError').val(),
	        		nameFile : $('#nameFile').val(),
	        		idCollection : $("#idCollection").val()},
	        url: baseUrl+'/communecter/admin/importinmongo/',
	        dataType : 'json',
	        success: function(data)
	        {
	            //console.dir(data);
	            if(data.result)
	              	toastr.success("Les données ont été ajouté.");
	            else
	                toastr.error("Erreur");
	           	//$.unblockUI();
	        }
	    });
  	});




  	$("#btnGeo").off().on('click', function()
  	{
  		/*$.getJSON( pathTmp+$("#nameFile").val()+"/jsonImport.json", function( data ) {
  			console.log(data);
		});*/

  		var dataGood = [];
  		var dataBad = jQuery.parseJSON($('#jsonError').val()) ;
  		console.log(dataBad);
  		var json = jQuery.parseJSON($('#jsonImport').val()) ;
  		$.each( json, function( key, org ) {
  			console.log("org", org);
  			console.log("typeof org.geo", typeof org.geo);
			if(typeof org.geo == "undefined"){

				org = getGeo(org) ;
			  	console.log("getGeoFINI");

				if(typeof org["msgError"] == "undefined")
			  		org = getInsee(org) ;
				

			  	//VerifierLesWarningg

				if($("#checkboxWarnings").is(':checked')){
					dataGood.push(org) ;
				}
				else{
					if(typeof org["msgError"] == "undefined" && typeof org["warnings"] == "undefined")
						dataGood.push(org) ;
					else
						dataBad.push(org) ;
					
				}
			}
			else if(org.address.codeInsee.trim().length == 0){

				org = getInsee(org) ;
				//VerifierLesWarningg
		  		if($("#checkboxWarnings").is(':checked')){
					dataGood.push(org) ;
				}
				else{
					if(typeof org["msgError"] == "undefined" && typeof org["warnings"] == "undefined")
						dataGood.push(org) ;
					else
						dataBad.push(org) ;
				}
			}
			else
				dataGood.push(org);

		});

		
		if($("#checkboxTest").is(':checked')){
			$("#divJsonImportView").JSONView(JSON.stringify(dataGood));
			$("#divJsonErrorView").JSONView(JSON.stringify(dataBad));
		}
		
		$("#jsonImport").val(JSON.stringify(dataGood));
		$("#jsonError").val(JSON.stringify(dataBad));
		
		var list = dataGood;
		$.each(dataBad, function(key, value){
			list.push(value)
		});		

		$.ajax({
	        type: 'POST', 
	        data: { list : list },
	        url: baseUrl+'/communecter/admin/checkdataimport/',
	        dataType : 'json',
	        success: function(data)
	        {
	            var chaine = "" ;
        		$.each(data, function(keyCsvContenu, valueCsvContenu){
        			chaine += "<tr>" ;
        			if(keyCsvContenu == 0)
        			{
        				$.each(valueCsvContenu, function(key, value){
        					chaine += "<th>"+value+"</th>";
        				});
        			}else{
						$.each(valueCsvContenu, function(key, value){
        					chaine += "<td>"+value+"</td>";
        				});
        			}
        			chaine += "</tr>" ;
        		});
        		$("#representation").html(chaine);
	        }
	    });

	    $("#btnImport").show();
		
  	});
}

function resultAssignData(data){

	//console.log(file[0]);
	var chaineSelectCSVHidden = "" ;
	if(data.typeFile == "csv"){
		$.each(file[0], function(key, value){
			chaineSelectCSVHidden += '<option value="' + key+'">'+value+'</option>';
			});
	}else if(data.typeFile == "json"){
		$.each(data.arbre, function(key, value){
			chaineSelectCSVHidden += '<option value="' + value+'">'+value+'</option>';
			});
	}
	$("#selectHeadCSV").html(chaineSelectCSVHidden);

	chainePathMapping = "" ;
	$.each(data.arrayPathMapping, function(key, value){
		chainePathMapping += '<option name="optionLinkCollection" value="' + value+'">'+value+'</option>';
	});

	$("#selectLinkCollection").html(chainePathMapping);

	/*chaineNameSubFile = "" ;
	$.each(data.subFiles, function(key, value){

		if(value.indexOf(data.nameFile) != -1 )
				chaineNameSubFile += '<option value="' + value+'">'+value+'</option>';
	});

	$("#subFile").html(chaineNameSubFile);*/

	//console.log("JSON", JSON.stringify(data.arrayCSV));
	/*chaineInputHidden = "" ;
	chaineInputHidden += '<input type="hidden" id="idCollection" value="' + data.idCollection + '"/>';
	chaineInputHidden += '<input type="hidden" id="nameFile" value="'+data.nameFile+'"/>';
	chaineInputHidden += '<input type="hidden" id="typeFile" value="'+data.typeFile+'"/>';*/
	/*console.log(data.json_origine);
	console.log(JSON.stringify(data.json_origine));*/
	/*if(data.typeFile == "csv")
		chaineInputHidden += '<input type="hidden" id="jsonCSV" value="'+ JSON.stringify(data.arrayCSV) + '"/>';
	if(data.typeFile == "json")
		chaineInputHidden += '<input type="hidden" id="jsonJSON" value="'+ JSON.stringify(data.json_origine) + '"/>';*/
		
	/*if(typeof data.jsonData == "undefined")
		file[0] = data.jsonData;

	$("#divInputHidden").html(chaineInputHidden);

	//console.log(("#jsonJSON").val());

	chaineSelectCSVHidden = "" ;

	if(data.typeFile == "csv"){
		$.each(file.arrayCSV[0], function(key, value){
			chaineSelectCSVHidden += '<option value="' + key+'">'+value+'</option>';
			});
	}else if(data.typeFile == "json"){
		$.each(data.arbre, function(key, value){
			chaineSelectCSVHidden += '<option value="' + value+'">'+value+'</option>';
			});
	}

	$("#selectHeadCSV").html(chaineSelectCSVHidden);


	//console.log("data.fieldsCollection",data.fieldsCollection);

	chainePathMapping = "" ;
	$.each(data.arrayPathMapping, function(key, value){
		chainePathMapping += '<option name="optionLinkCollection" value="' + value+'">'+value+'</option>';
	});

	$("#selectLinkCollection").html(chainePathMapping);
	bindEvents();*/
}





function getInseeWithLatLon(lat, lon, cp){
	var insee = "" ;
	$.ajax({
		type: 'POST',
		data: { 
			latitude : lat,
			longitude : lon,
			cp : cp
		},
		async:false,
		url: baseUrl+'/communecter/sig/getinseebylatlng/',
		dataType : 'json',
		success: function(data){
			insee = data.insee ;
		}
	});

	return insee ;
	
}

function getInfoAdressByInsee(insee,cp){
	var alternateName = "" ;
	$.ajax({
		type: 'POST',
		data: { 
			insee : insee,
			cp : cp
		},
		async:false,
		url: baseUrl+'/communecter/city/getinfoadressbyinsee/',
		dataType : 'json',
		success: function(data){
			//console.log(data);
			$.each(data, function( key, val ) {
				console.log(val);
				alternateName = val.alternateName ;
			});
			
		}
	});

	return alternateName ;	
}





function callbackNominatimSuccess(obj){
	return obj ;
}
//https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=YOUR_API_KEY

function findGeoposByGoogleMaps(requestPart){
	var keyApp = "<?php echo Yii::app()->params['google']['keyAPP']; ?>";
	var objnominatim = {} ;
	console.log('findGeoposByGoogleMaps',"https://maps.googleapis.com/maps/api/geocode/json?address=" + requestPart + "&key="+keyApp);
	showLoadingMsg("Recherche de la position en cours");
	$.ajax({
		url: "//maps.googleapis.com/maps/api/geocode/json?address=" + requestPart + "&key="+keyApp,
		type: 'POST',
		dataType: 'json',
		async:false,
		crossDomain:true,
		complete: function () {},
		success: function (obj){
			//console.log('success');	
			hideLoadingMsg();
			objnominatim = callbackNominatimSuccess(obj);
		},
		error: function (error) {
			//console.log('error');	
			return callbackNominatimError(error);
		}
	});

	return objnominatim ;

}


function findGeoposByNominatim(requestPart){
	var objnominatim = {} ;
	//console.log('findGeoposByNominatim');
	showLoadingMsg("Recherche de la position en cours");
	$.ajax({
		url: "//nominatim.openstreetmap.org/search?q=" + requestPart + "&format=json&polygon=0&addressdetails=1",
		type: 'POST',
		dataType: 'json',
		async:false,
		crossDomain:true,
		complete: function () {},
		success: function (obj){
			//console.log('success');	
			hideLoadingMsg();
			objnominatim = callbackNominatimSuccess(obj);
		},
		error: function (error) {
			//console.log('error');	
			return callbackNominatimError(error);
		}
	});

	return objnominatim ;

}


function addNewMappingForSelecte(arrayMap, subArray)
{
	var firstElt = arrayMap[0] ;
	arrayMap.shift();
	var beInt = parseInt(firstElt);
	var newSelect = {} ;

	if(!isNaN(beInt))
	{
		beInt++;
		if(subArray)
		{	
			if(arrayMap.length >= 1)
			{
				var newArrayMap = jQuery.extend([], arrayMap);
				newSelect[firstElt] = addNewMappingForSelecte(arrayMap, subArray);
				newSelect[beInt.toString()] = addNewMappingForSelecte(newArrayMap, subArray);
			}
			else
			{
				newSelect[firstElt] = "";
				newSelect[beInt.toString()] = "";
			}
		}
		else
		{
			if(arrayMap.length >= 1)
			{
				subArray = true ;
				newSelect[beInt.toString()] = addNewMappingForSelecte(arrayMap, subArray);
			}
			else
			{
				newSelect[beInt.toString()] = "";
			}
		}
	}
	else
	{
		if(arrayMap.length >=1)
		{
			newSelect[firstElt] = addNewMappingForSelecte(arrayMap, true);
		}
		else
		{
			newSelect[firstElt] = "";
		}
	}
	return newSelect ;
}

function callbackNominatimSuccess(obj){
	//console.log("obj" , obj);
	return obj ;
}

function getOptionHTML(arrayOption, objectOption, father)
{
	if(!jQuery.isPlainObject(objectOption))
	{
		arrayOption.push(father);
	}
	else
	{
		$.each(objectOption, function(key, values){
			if(father != "")
				var newfather = father +"."+ key
			else
				var newfather = key
			getOptionHTML(arrayOption, values, newfather);
		});
	}
}

function verifNameSelected(arrayName)
{
	var find = false ; 

	$.each(arrayName, function(key, value){
		var beInt = parseInt(value);
		if(!isNaN(beInt))
		{
			find = true ;
		}
	});

	return find ;
}

function verifBeforeAddSelect(arrayMap)
{
	$('[name=optionLinkCollection]').each(function() {
	  	var option = $(this).val() ;
	  	var position = jQuery.inArray( option, arrayMap);
	  	if(position != -1)
	  		arrayMap.splice(position, 1);
		//console.log("option", option);
	});
}

function autoCompleteInviteSearch(search){
	tabObject = [];

	var data = { 
		"search" : search,
		"searchMode" : "personOnly"
	};
	var urlurl = baseUrl+"/communecter/search/searchmemberautocomplete" ;
	console.log("url", urlurl);

	ajaxPost("", urlurl, data,
		function (data){
			var str = "<li class='li-dropdown-scope'><a href='javascript:newInvitation()'>Pas trouvé ? Lancer une invitation à rejoindre votre réseau !</li>";
			var compt = 0;
			var city, postalCode = "";
			$.each(data["citoyens"], function(k, v) { 
				city = "";
				postalCode = "";
				var htmlIco ="<i class='fa fa-user fa-2x'></i>"
				if(v.id != userId) {
					tabObject.push(v);
	 				if(v.profilImageUrl != ""){
	 					var htmlIco= "<img width='50' height='50' alt='image' class='img-circle' src='"+baseUrl+v.profilImageUrl+"'/>"
	 				}
	 				if (v.address != null) {
	 					city = v.address.addressLocality;
	 					postalCode = v.address.postalCode;
	 				}
	  				str += 	"<li class='li-dropdown-scope'>" +
	  						"<a href='javascript:selectPeopleForLink("+compt+")'>"+htmlIco+" "+v.name + 
	  						"<span class='city-search'> "+postalCode+" "+city+"</span>"+"</a>"+
	  						"</li>";
	  				compt++;
  				}
			});
			console.log("str : ", str);
			$("#dropdown_searchInvite").html(str);
			$("#dropdown_searchInvite").css({"display" : "inline" });
		}
	);	
}


function selectPeopleForLink(num){

	var person = tabObject[num];
	var personId = person["id"];

	console.log(person, personId, person["name"]);
	$("#memberId").html(personId);
	$("#namePeople").html(person["name"]);
	$("#dropdown_searchInvite").css({"display" : "none" });	
	
}



function getInsee(org){
	console.log("getInsee");
	var address = org.address;
	address.codeInsee = getInseeWithLatLon(org.geo.latitude, org.geo.longitude, org.address.postalCode);
	
	if(typeof address.codeInsee != "undefined"){
		if(address.codeInsee.trim().length != 0 ){
			var locality = getInfoAdressByInsee(address.codeInsee, address.postalCode );
			if(locality.trim().length != 0 || typeof locality != "undefined")
				address.addressLocality = locality ;
			else{
				if($("#checkboxWarnings").is(':checked'))
					org["warnings"].push("111") ;
				else
					org["msgError"] = "111" ;
			}
		}
		else{
			if($("#checkboxWarnings").is(':checked'))
				org["warnings"].push("112") ;
			else
				org["msgError"] = "112" ;
		}
	}
	else{
		if($("#checkboxWarnings").is(':checked'))
			org["warnings"].push("112") ;
		else
			org["msgError"] = "112" ;
	}

	org["address"] = address;

	return org ;
	
}




function getGeo(org){
	console.log("getGeo");
	var adressLong = "" ;
   	var adressShort = "" ;

   	var nbNominatim = 0;
  	var nbGoogle = 0;

	if(typeof org.address.streetAddress != "undefined"){
		if(org.address.streetAddress.trim() != "")
			adressLong = adressLong + org.address.streetAddress ;
	}
		
	if(typeof org.address.postalCode != "undefined"){
		if(org.address.postalCode.trim() != ""){
			adressLong = adressLong + ", " + org.address.postalCode;
			adressShort += org.address.postalCode;
		}
	}

	if(typeof org.address.addressLocality != "undefined"){	
		if(org.address.addressLocality.trim() != ""){
			adressLong = adressLong + ", " +  org.address.addressLocality;
			adressShort += ", " + org.address.addressLocality
		}
	}	

	
	var addressLongTransform = transformNominatimUrl(adressLong);
	
  	//lance la requette nominatim (sig/geoloc.js l.109)
  	var objNominatim = findGeoposByNominatim(addressLongTransform);
		
	var geo = {};
	var address = org.address;
	
	geo["@type"] = "GeoCoordinates";
	
	if(objNominatim.length != 0){
		valNominatim = objNominatim[0];
		geo["latitude"] = valNominatim.lat;
		geo["longitude"] = valNominatim.lon;
		nbNominatim = nbNominatim + 1 ;	
	}else{
		objGoogleMaps = findGeoposByGoogleMaps(addressLongTransform);
		console.log("objGoogleMaps", objGoogleMaps, objGoogleMaps.results.length);
		if(objGoogleMaps.results.length != 0){	
			var valGoogleMaps = objGoogleMaps.results[0] ;
			geo["latitude"] = valGoogleMaps.geometry.location.lat;
			geo["longitude"] = valGoogleMaps.geometry.location.lng;
			nbGoogle = nbGoogle + 1 ;
		}else{
			console.log("objNominatim");
			var adressShortTransform = transformNominatimUrl(adressShort);
			objNominatim = findGeoposByNominatim(adressShortTransform);
			if(objNominatim.length != 0){
				valNominatim = objNominatim[0];
				geo["latitude"] = valNominatim.lat;
				geo["longitude"] = valNominatim.lon;
				org["warnings"].push("153") ;
				nbNominatim = nbNominatim + 1 ;

			}else{
				objGoogleMaps = findGeoposByGoogleMaps(adressShortTransform);
				console.log("objGoogleMaps", objGoogleMaps, objGoogleMaps.results.length);
				if(objGoogleMaps.results.length != 0 && objGoogleMaps.status != "ZERO_RESULTS"){	
					var valGoogleMaps = objGoogleMaps.results[0] ;
					geo["latitude"] = valGoogleMaps.geometry.location.lat;
					geo["longitude"] = valGoogleMaps.geometry.location.lng;
					org["warnings"].push("153") ;
					nbGoogle = nbGoogle + 1 ;
				}
				else{
					if($("#checkboxWarnings").is(':checked'))
						org["warnings"].push("154") ;
					else
						org["msgError"] = "154" ;
				}
					
	  		}
	  	}
	}

	if(typeof org["msgError"] == "undefined")
		org["geo"] = geo ;
	

	return org ;
	
}


function assignData(subfile, typeFile){
	console.log("typeFile", typeFile);
	$.ajax({
        type: 'POST',
        data: {
        		file : subfile,
        		typeFile : typeFile
        	},
        url: baseUrl+'/communecter/admin/assigndata/',
        dataType : 'json',
        async : false,
        success: function(data)
        {
        	console.log("data",data);
        	if(data.createLink){

        		resultAssignData(data);
        		$("#createLink").show();
        	}
        	else{

        	}

        }
	});
}


function assignData2(idMicroformat, typeFile){
	$.ajax({
        type: 'POST',
        data: {
        		idMicroformat : idMicroformat,
        		typeFile : typeFile
        	},
        url: baseUrl+'/communecter/admin/assigndata/',
        dataType : 'json',
        async : false,
        success: function(data)
        {
        	console.log("assignData2 data",data.createLink);
        	if(data.createLink){
        		resultAssignData(data);
        		$("#createLink").show();
        	}
        	else{

        	}

        }
	});
}


function visualisation(params){
	$.ajax({
        type: 'POST',
        data: params,
        url: baseUrl+'/communecter/admin/previewData/',
        dataType : 'json',
        success: function(data)
        {
        	console.log("visualisation data",data.result);
        	if(data.result){
        		
        		if($("#checkboxTest").is(':checked')){
        			$("#divJsonImportView").JSONView(data.jsonImport);
        			$("#divJsonErrorView").JSONView(data.jsonError);
        		}
        		

        		$("#jsonImport").val(data.jsonImport);
        		$("#jsonError").val(data.jsonError);

				var chaine = "" ;
        		$.each(data.listEntite, function(keyListEntite, valueListEntite){
        			chaine += "<tr>" ;
        			if(keyListEntite == 0)
        			{
        				$.each(valueListEntite, function(key, value){
        					chaine += "<th>"+value+"</th>";
        				});
        			}else{
						$.each(valueListEntite, function(key, value){
        					chaine += "<td>"+value+"</td>";
        				});
        			}
        			chaine += "</tr>" ;
        		});
        		$("#representation").html(chaine);


        		if(data.geo == true){
        			$("#btnGeo").show();
        		}else{
        			$("#btnGeo").hide();
        		}

        		if($("#checkboxTest").is(':checked')){
        			$("#btnImport").hide();
        		}else
        			$("#btnImport").show();
        			
        			

        		$("#verifBeforeImport").show();




        		$.unblockUI();
        	}
        }
    });
}


function createJson(params){
	$.ajax({
        type: 'POST',
        data: params,
        url: baseUrl+'/communecter/admin/createfileforimport/',
        dataType : 'json',
        success: function(data)
        {
        	console.log("createfileforimport",data);
        	$("#verifBeforeImport").show();
        	if(data.result)
        	{
        		//console.log("data.jsonImport",data.jsonImport);
        		//$("#divJsonImportView").JSONView(data.jsonImport);
        		//$("#divJsonImportView").JSON.stringify(data.jsonImport)
        		$("#jsonImport").val(data.jsonImport);
        		$("#jsonError").val(data.jsonError);
        		//$("#divJsonErrorView").JSONView(data.jsonError);
        		console.log("listEntite", data.listEntite);
				var chaine = "" ;
        		$.each(data.listEntite, function(keyListEntite, valueListEntite){
        			chaine += "<tr>" ;
        			if(keyListEntite == 0)
        			{
        				$.each(valueListEntite, function(key, value){
        					chaine += "<th>"+value+"</th>";
        				});
        			}else{
						$.each(valueListEntite, function(key, value){
        					chaine += "<td>"+value+"</td>";
        				});
        			}
        			chaine += "</tr>" ;
        		});
        		$("#representation").html(chaine);
        		$("#verifBeforeImport").show();
        		$("#affichageJSON").show();
				$.unblockUI();
        	}
        	$.unblockUI();
        }
    });
}

</script>