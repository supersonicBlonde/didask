//****************************************************************
// This script is designed to manipulate pseudo elements - add a style 
//*****************************************************************
var UID = {
	_current: 0,
	getNew: function(){
		this._current++;
		return this._current;
	}
};

HTMLElement.prototype.pseudoStyle = function(element,prop,value){
	var _this = this;
	var _sheetId = "pseudoStyles";
	var _head = document.head || document.getElementsByTagName('head')[0];
	var _sheet = document.getElementById(_sheetId) || document.createElement('style');
	_sheet.id = _sheetId;
	var className = "pseudoStyle" + UID.getNew();
	
	_this.className +=  " "+className; 
	
	_sheet.innerHTML += " ."+className+":"+element+"{"+prop+":"+value+"}";
	_head.appendChild(_sheet);
	return this;
};



/**********************************************************************************/
function update_progress_bar(id_parcours) {
	console.log(id_parcours);
	jQuery.ajax({
		url : ajax_js_obj.ajax_url,
		dataType: 'json',
		type : 'post',
		data : {
			action : 'get_progress_bar', 
			parcours: id_parcours, 
			submitted_nonce : ajax_js_obj.the_nonce,
		},
		
		success : function( response ) { 
			let completed = response['completed'];
			let percent = response['percent'];
			let achieved = response['achieved'];
			let episodes_number = response['episodes_number'];

			let text = document.getElementById('progress-text');
			let checkmark = document.getElementById('checkmark');
			let bar = document.getElementById('bar');
			let completed_div = document.getElementById('completed');

			let progress_text = achieved + ' épisode' + (achieved > 1?'s':'') + ' terminé' + (achieved > 1?'s':'') + ' sur ' + episodes_number;
			text.innerHTML = progress_text;

			if(completed == 1) {
				checkmark.style.display = "inline";
				completed_div.style.display = "block";
			} 
			else {
				checkmark.style.display = "none";
				completed_div.style.display = "none";
			}
			console.log("percent",percent);
			bar.style.width = percent+'%';

			
		},
		complete:function(data){
	    	//document.getElementById('preloader').classList.add('hide');
	   },
		error : function( response ) {
			console.log('Error retrieving the information: ' + response.status + ' ' + response.statusText);
			//console.log( response );
		}
	});
}

function set_preloader(state) {

	if(state == true) {
		let preloader = document.createElement('div');
		preloader.setAttribute('id', 'preloader');
		preloader.innerHTML = '<img src="/wp-content/themes/didask/img/loader.gif">';
		document.body.appendChild(preloader);
	}
	else {
		document.getElementById("preloader").remove();
	}
}

function set_overlay(state) {

	let overlay = document.getElementById('overlay');
	let scale = document.querySelector('.scale');

	if(state === true) { 
		overlay.classList.add('show');
		overlay.classList.remove('hide');
		scale.classList.add('scaleOut');
		scale.classList.remove('scaleIn');
	} 
	else {
		overlay.classList.remove('show');
		overlay.classList.add('hide');
		scale.classList.add('scaleIn');
		scale.classList.remove('scaleOut');
	}
}

function get_index(elt, ar) {
	return Array.prototype.indexOf.call(ar, elt);
           /* let parent = elt.parentNode; 
             return Array.prototype.indexOf.call(parent.children, elt); */
}

function getIndexOf_multi_dim_array(ar, needle){
    if (!ar){
        return [];
    }
    
    for(var i=0; i<ar.length; i++){
        var index = ar[i].indexOf(needle);
        if (index > -1){
            return [i, index];
        }
    }
    
    return [];
}


function slice_array_by_chunk(ar, chunk) {
	
	let new_ar = [];
	let subset;
	for (var i=0; i < ar.length; i += chunk) {
    	subset = ar.slice(i, i+chunk);
  		new_ar.push(subset);
	}
	return new_ar;
	   
}

function fade_all_episodes(current, episodes) {
	episodes.forEach(item => {
		if(item != current) {
			item.style.opacity = .5;
		}
	})
}

function hide_all_modules(ar_episodes, ar_blocs) {

	ar_blocs.forEach(item => {
		item.style.display = "none";
	});

    let to_remove = document.querySelector('.episodes-list .content-episode-container');
    if(to_remove != null) { to_remove.remove();}
   

	ar_episodes.forEach(item => {
		item.classList.remove('selected');
		item.style.opacity = 1;
	});
}
 
function close() {
	 let ar_blocs = document.querySelectorAll('.content-episode-container');
	 remove_all_modules(ar, ar_blocs);
}

function save_progression(index, id_parcours , id_episode) {

		jQuery.ajax({
		url : ajax_js_obj.ajax_url,
		beforeSend: function( xhr ) {
    		set_overlay(true);
    		set_preloader(true);
  		},
		dataType: 'json',
		type : 'post',
		data : {
			item_index: index,
			action : 'save_tracking', 
			episode: id_episode,
			parcours: id_parcours, 
			submitted_nonce : ajax_js_obj.the_nonce,
		},
		
		success : function( response ) { 

			if(response['insert'] === 1) {
				console.log('response.ok');
				set_overlay(false);
				set_preloader(false);

				let id_episode = response['id_episode'];
				let element_to_replace = document.querySelector("[data-episode_saved = '"+id_episode+"']");
				let bloc_episode = document.querySelector("[data-episode = '"+id_episode+"']");
				let cb_container = bloc_episode.querySelector(".checkbox-discover");

				element_to_replace.innerHTML = '<div class="text-uppercase pb-2 success"><span class="bravo">BRAVO</span>Votre équipe a terminé cet épisode.</div><div ><a href="#" class="cancel-track">Annuler</a></div>';


				/*let index = response['index'];
				let ar = document.querySelectorAll('.save-section');
				let episode_ar = document.querySelectorAll('.episode-item');
				console.log('arindex', ar[index]);*/
				

				//let cb_container = episode_ar[index].querySelector('.checkbox-discover'); 
				cb_container.querySelector('input').checked = true;
				cb_container.querySelector('.text-label').innerHTML = "Terminé";
				if(response['completed'] == 1) {
					let parcours_secondaire = document.getElementById('parcours-secondaire');
					parcours_secondaire.style.display = 'block';
					parcours_secondaire.scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
				}
				update_progress_bar(id_parcours);
			}
		},
		complete:function(data){
	    	//document.getElementById('preloader').classList.add('hide');
	   },
		error : function( response ) {
			console.log('Error retrieving the information: ' + response.status + ' ' + response.statusText);
			//console.log( response );
		}
	});
}


function cancel_progression(index, id_parcours , id_episode) {

		jQuery.ajax({
		url : ajax_js_obj.ajax_url,
		beforeSend: function( xhr ) {
    		set_overlay(true);
    		set_preloader(true);
  		},
		dataType: 'json',
		type : 'post',
		data : {
			item_index: index,
			action : 'cancel_tracking', 
			episode: id_episode,
			parcours: id_parcours, 
			submitted_nonce : ajax_js_obj.the_nonce,
		},
		
		success : function( response ) { 

			if(response['update'] === 1) {
				console.log('update.ok');
				set_overlay(false);
				set_preloader(false);

				let id_episode = response['id_episode'];
				let element_to_replace = document.querySelector("[data-episode_saved = '"+id_episode+"']");
				let bloc_episode = document.querySelector("[data-episode = '"+id_episode+"']");
				let cb_container = bloc_episode.querySelector(".checkbox-discover");

				element_to_replace.innerHTML = '<div class="text-uppercase pb-2">Vous avez terminé ?</div><div class="default-btn btn-invert"><a href="/" class="track-btn">Cliquez ici pour l`\'enregistrer</a></div>';


				/*let index = response['index'];
				let ar = document.querySelectorAll('.save-section');
				let episode_ar = document.querySelectorAll('.episode-item');
				
				console.log('arindex', ar[index]);
				let cb_container = episode_ar[index].querySelector('.checkbox-discover'); */
				cb_container.querySelector('input').checked = false;
				cb_container.querySelector('.text-label').innerHTML = "A découvrir";
				update_progress_bar(id_parcours);
			}
		},
		complete:function(data){
	    	//document.getElementById('preloader').classList.add('hide');
	   },
		error : function( response ) {
			console.log('Error retrieving the information: ' + response.status + ' ' + response.statusText);
			//console.log( response );
		}
	});
}


function navbarAnimate(el) {
	el.animate([
	  // keyframes
	  /*{ height: 0, 'opacity': 0 }, 
	  { height: '80vh', 'opacity': 1 }*/
	  {  'opacity': 0 }, 
	  { 'opacity': 1 }
	], { 
	  // timing options
	  duration:800,
	  easing: 'ease-out',
	  iterations: 1 
	});
}


//*******************************************************
//				JS RESPONSIVE
//*******************************************************

function on_click_save_section(pos, event) {
	event.preventDefault();
	let parent = event.target.parentElement.parentElement;
	if(event.target.className == "track-btn") {
		let id_parcours = parent.dataset.parcours;
		let id_episode = parent.dataset.episode_saved;
		console.log("track pos",pos,"parcours",id_parcours,"episode", id_episode);
		save_progression(pos, id_parcours , id_episode);
	}
	else if(event.target.className == "cancel-track") {
		if(!confirm("Etes-vous sûr de vouloir annuler ?")) 
			return;			  		
		let id_parcours = parent.dataset.parcours;
		let id_episode = parent.dataset.episode_saved;
		console.log("cancel pos",pos,"parcours",id_parcours,"episode", id_episode);
		cancel_progression(pos, id_parcours , id_episode);
	}
}




function clone_element(ar_blocs, pos) {
	let clone = ar_blocs[pos].cloneNode(true);
	console.log(clone);
	clone.style.display = "block";
	
	return clone;
}



function insert_clone(parentNode, newNode, ar, referenceNode) {
	let clone = parentNode.insertBefore(newNode, ar[referenceNode]);
	clone.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
	return clone;
}


/*function display_content_sm(breakpoint, pos, episode_container, ar_blocs, ar) {

	 let count_children = episode_container.childElementCount;
	   console.log("count children", count_children);
	   console.log("nb rows", Math.ceil(count_children/2));
	   let copy = [];
	   
		const chunk = 2;
		let subset;

		for (var i=0; i < count_children; i += chunk) {
		    subset = myArray.slice(i, i+chunk);
		  copy.push(subset);
		}

		console.log("copyindew",copy.findIndex(3));

	
	console.log("ar",ar);
	let clone = clone_element(ar_blocs, pos);
	let index = 0;
	console.log(breakpoint);

	switch(breakpoint) {

		case 576:
		 index = (pos  % 2 == 0)?(pos+2):(pos+1);
		 break;

		 case 768:
		 index = 3;
		 break;
	}
	console.log("index",);
	insert_clone(episode_container, clone, ar, pos);
	
	//let ar_all = document.querySelectorAll('.save-section');
	clone.querySelector('.save-section').addEventListener('click' , event => {

		on_click_save_section(pos, event);
		
	});
}*/
 

function display_content_lg(pos, episode_container, ar_blocs, ar) {

	console.log("ar_blocs" , ar_blocs);

	var xsm = window.matchMedia("(max-width: 576px)");
	var x768 = window.matchMedia("(min-width: 768px)");
	var x576 = window.matchMedia("(min-width: 576px)");
	var x1200 = window.matchMedia("(min-width: 1200px)");
	let chunk = 4;

	console.log("resp",x768.matches);

	if(xsm.matches) {
		chunk = 1;
	}
	if(x576.matches) {
		chunk = 2;
	}
	if(x768.matches) {
		chunk = 3;
	}
	if(x1200.matches) {
		chunk = 4;
	}
	  // if there is more than 3 episodes, the bloc will appear in the middle
	   // so get the number of episodes 
	   let count_children = episode_container.childElementCount;

	   let elements = [];

	   ar.forEach(function(item, num) {
	   	elements.push(num);
	   });

	   console.log('elements',elements);


	   
	   let rows = slice_array_by_chunk(elements , chunk);
	  

	   let indexOf = getIndexOf_multi_dim_array(rows, pos);

	   let row = indexOf[0];
	   let pos_in_row = indexOf[1];
 	   console.log("rows", rows);
	   console.log("row", row, 'pos_in_row', pos_in_row);

	   let element_to_clone_under = rows[row][chunk-1]; 

	   console.log("element_to_clone_under" , element_to_clone_under);


	   
	   let index = 3;
	   if(episode_container.classList.contains('library')) index = 4;

	   let clone = clone_element(ar_blocs, pos);
	   insert_clone(episode_container, clone, ar, element_to_clone_under+1);
	   let ar_all = document.querySelectorAll('.save-section');
   		clone.querySelector('.save-section').addEventListener('click' , event => {
   			on_click_save_section(pos, event);
   			
   		});

	   /*if(count_children > index && pos < index) { 
	   		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	   		// cloning won't keep event listeners
	   		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	   		let clone = clone_element(ar_blocs, pos);
	   		insert_clone(episode_container, clone, ar, element_to_clone_under);
	    	 
	    	//let ar_all = document.querySelectorAll('.save-section');
	   		clone.querySelector('.save-section').addEventListener('click' , event => {
	   			on_click_save_section(pos, event);
	   			
	   		});
	    } 
	    else {
	    	// show the block episode content
			ar_blocs[pos].style.display = "block";	
	    }*/
}

var callback = function() {


	jQuery('.colored').matchHeight();




	let scroll_btn = document.querySelectorAll('.scroll-next a');

	scroll_btn.forEach(item => {
	  item.addEventListener('click', event => {
	  	event.preventDefault(); 
	  	let parent = item.closest('.section');
	  	let next_section = parent.nextElementSibling;
	  	next_section.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
	  	})
	});
	//****************************************
	// MENU HAMBURGER
	//****************************************
	
	let toggler  = document.querySelector('.navbar-toggler');
	let collapse = document.getElementById('navbarNav');
	let header   = document.getElementById("header-container");


	toggler.addEventListener('click' , function(event) {
		if (collapse.classList.contains('show')) {
			console.log('close');
    		/*collapse.classList.remove('show'); */
    		header.classList.remove('open');
		}
		else {
			/*collapse.classList.add('show');*/
			header.classList.add('open');
			console.log('open');
		}
	});

	/******************************************/



  let all_episodes = document.querySelectorAll('.episode-item');
  let all_contents = document.querySelectorAll('.content-episode-container');
 // let parent_node = document.querySelector('.episodes-list'); 
 
  document.querySelectorAll('.episode-item').forEach(item => {
	  item.addEventListener('click', event => {
	  	

	  	/*console.log("resp", x576.matches);
	  	console.log("resp", x768.matches);*/

	  	// Get parent of item (episode-list) to determine the list 
		let episode_container = item.parentElement;

		// get the parent of contents (content-list) of the bloc
		let contents_container = episode_container.nextElementSibling;

		// get all episode of the bloc
		let ar = episode_container.querySelectorAll('.episode-item');


		// get all contents of the bloc
		let ar_blocs = contents_container.querySelectorAll('.content-episode-container');

		// on click hide all modules
	  	hide_all_modules(all_episodes, all_contents);
	  	fade_all_episodes(item , all_episodes);
	  	// add the style on episode selected
	  	item.classList.add('selected');
	  	
	  	// get the color of the episode
	  	let colored = item.querySelector('.colored');
	  	let color = colored.dataset.color;
	  	// and add the colored triangle
	  	colored.pseudoStyle("after","border-top-color",color+'!important');

	  	
	  	// get the position of the episode
	    let pos = get_index(item, ar); 
	    console.log("pos", pos);
	    console.log("ar_blocs", ar_blocs);


		display_content_lg(pos , episode_container, ar_blocs, ar);

		/*if(x992.matches) {
	  		display_content_lg(pos , episode_container, ar_blocs, ar);
	  	}
	  	else if(x576.matches){
	  		display_content_sm(576, pos , episode_container, ar_blocs, ar);	
	  	}
	  	else if(x768.matches){
	  		display_content_sm(768, pos , episode_container, ar_blocs, ar);	
	  	}*/
	       

	   // if there is more than 3 episodes, the bloc will appear in the middle
	   // so get the number of episodes 
	   /*let count_children = episode_container.childElementCount;
	   console.log("count children", count_children);*/

	  /* if(count_children > 3 && pos < 3) { 
	   		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	   		// cloning won't keep event listeners
	   		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	   		let clone = ar_blocs[pos].cloneNode(true);
	   		console.log(clone);
	    	clone.style.display = "block";
	    	episode_container.insertBefore(clone, ar[3]);
	    	let ar_all = document.querySelectorAll('.save-section');
	   		clone.querySelector('.save-section').addEventListener('click' , event => {
	   			event.preventDefault();
 				let parent = event.target.parentElement.parentElement;
	  			if(event.target.className == "track-btn") {
			  	   // let pos = get_index(item, ar_all); 
			  	  
			  		let id_parcours = parent.dataset.parcours;
			  		let id_episode = parent.dataset.episode_saved;
			  		console.log("track pos",pos,"parcours",id_parcours,"episode", id_episode);
			  		save_progression(pos, id_parcours , id_episode);
			  	}
			  	else if(event.target.className == "cancel-track") {
			  		if(!confirm("Etes-vous sûr de vouloir annuler ?")) 
			  			return;
			  	   // let pos = get_index(item, ar_all); 
			  		let id_parcours = parent.dataset.parcours;
			  		let id_episode = parent.dataset.episode_saved;
			  		console.log("cancel pos",pos,"parcours",id_parcours,"episode", id_episode);
			  		cancel_progression(pos, id_parcours , id_episode);
				}
	   		});



	    }
	    else {
	    	// show the block episode content
			ar_blocs[pos].style.display = "block";	
	    }*/
	  })
	})



  	document.querySelectorAll(".save-section").forEach(item => {
  		let ar = document.querySelectorAll('.save-section');
  		item.addEventListener('click' , event => {
  			event.preventDefault();
  			if(event.target.className == "track-btn") {
  				console.log("clicked");
		  	    let pos = get_index(item, ar); 
		  	    
		  		let id_parcours = item.dataset.parcours;
		  		let id_episode = item.dataset.episode_saved;
		  		console.log("track pos",pos,"parcours",id_parcours,"episode", id_episode);
		  		save_progression(pos, id_parcours , id_episode);
		  	}
		  	else if(event.target.className == "cancel-track") {
		  		if(!confirm("Etes-vous sûr de vouloir annuler ?")) 
		  			return;
		  		
		  	    let pos = get_index(item, ar); 
		  		let id_parcours = item.dataset.parcours;
		  		let id_episode = item.dataset.episode_saved;
		  		console.log("cancel pos",pos,"parcours",id_parcours,"episode", id_episode);
		  		cancel_progression(pos, id_parcours , id_episode);
			}
  		})
  	});


}

if (
    document.readyState === "complete" ||
    (document.readyState !== "loading" && !document.documentElement.doScroll)
) {
  callback();
} else {
  document.addEventListener("DOMContentLoaded", callback);
}

