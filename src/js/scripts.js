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
}

function remove_all_modules(ar_episodes, ar_blocs) {
	ar_blocs.forEach(item => {
		item.style.display = "none";
	});

	ar_episodes.forEach(item => {
		item.classList.remove('selected');
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
				set_overlay(false);
				set_preloader(false);
				let index = response['index'];
				let ar = document.querySelectorAll('.save-section');
				let episode_ar = document.querySelectorAll('.episode-item');
				ar[index].innerHTML = '<div class="text-uppercase pb-2 success"><span class="bravo">BRAVO</span>Votre équipe a terminé cet épisode.</div><div ><a href="#" class="cancel-track">Annuler</a></div>';
				let cb_container = episode_ar[index].querySelector('.checkbox-discover'); 
				cb_container.querySelector('input').checked = true;
				cb_container.querySelector('label').innerHTML = "Terminé";
				if(response['completed'] == 1) {
					let parcours_secondaire = document.getElementById('parcours-secondaire');
					parcours_secondaire.style.display = 'block';
					parcours_secondaire.scrollIntoView();
				}
				//update_progress_bar();
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

			console.log(response);

			if(response['update'] === 1) {
				set_overlay(false);
				set_preloader(false);
				let index = response['index'];
				let ar = document.querySelectorAll('.save-section');
				let episode_ar = document.querySelectorAll('.episode-item');
				ar[index].innerHTML = '<div class="text-uppercase pb-2">Vous avez terminé ?</div><div class="default-btn btn-invert"><a href="/" class="track-btn">Cliquez ici pour l`\'enregistrer</a></div>';
				let cb_container = episode_ar[index].querySelector('.checkbox-discover'); 
				cb_container.querySelector('input').checked = true;
				cb_container.querySelector('label').innerHTML = "Terminé";
				//update_progress_bar();
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

var callback = function() {

	//****************************************
	// MENU HAMBURGER
	//****************************************
	
	/*let toggler = document.querySelector('.navbar-toggler');
	let collapse = document.getElementById('navbarNav');


	toggler.addEventListener('click' , function(event) {
		if (collapse.classList.contains('show')) {
    		collapse.classList.remove('show'); 
    		document.getElementById('header-container').classList.remove('open');
		}
		else {
			collapse.classList.add('show');
			document.getElementById('header-container').classList.add('open');
			navbarAnimate(collapse);
		}
	});*/

	/******************************************/



  let ar = document.querySelectorAll('.episode-item');
  let ar_blocs = document.querySelectorAll('.content-episode-container');
  let parent_node = document.querySelector('.episodes-list');
 
  document.querySelectorAll('.episode-item').forEach(item => {
	  item.addEventListener('click', event => {
	  	remove_all_modules(ar, ar_blocs);
	  	item.classList.add('selected');
	  	let colored = item.querySelector('.colored');
	  	let color = colored.dataset.color;
	  	colored.pseudoStyle("after","border-top-color",color+'!important');
	    let pos = get_index(item, ar); 
	    ar_blocs[pos].style.display = "block";
	    if(pos < 3) { 
	    	parent_node.insertBefore(ar_blocs[pos], ar[3]);
	    	/*for(let i = 3; i < 6 ; i++){
	    		ar[i].style.top = ar_blocs[i].offsetHeight+"px"; 

	    	} */
	    }
	  })
	})

/* document.querySelectorAll(".cancel-track a").forEach(item => {
  	item.addEventListener('click' , event => {
  		
  		if(!confirm("Etes-vous sûr de vouloir annuler ?")) 
  			return;
  		event.preventDefault();
  		let ar = document.querySelectorAll('.save-section');
  		let parent = item.parentNode.parentNode;
  	    let pos = get_index(parent, ar); 
  		let id_parcours = parent.dataset.parcours;
  		let id_episode = parent.dataset.episode;
  		console.log(id_parcours , id_episode);
  		cancel_progression(pos, id_parcours , id_episode);
  	})
  });
*/
  /*document.querySelectorAll(".track-btn").forEach(item => {
  	item.addEventListener('click' , event => {
  		console.log("track");
  		event.preventDefault(); 
  		let ar = document.querySelectorAll('.save-section');
  		let parent = item.parentNode.parentNode;
  	    let pos = get_index(parent, ar); 
  		let id_parcours = item.dataset.parcours;
  		let id_episode = item.dataset.episode;
  		
  		save_progression(pos, id_parcours , id_episode);

  	})
  })*/

  	document.querySelectorAll(".save-section").forEach(item => {
  		let ar = document.querySelectorAll('.save-section');
  		item.addEventListener('click' , event => {
  			event.preventDefault();
  			if(event.target.className == "track-btn") {
  				console.log(item);
				

		  	    let pos = get_index(item, ar); 
		  		let id_parcours = item.dataset.parcours;
		  		let id_episode = item.dataset.episode;
		  		
		  		save_progression(pos, id_parcours , id_episode);
		  	}
		  	else if(event.target.className == "cancel-track") {
		  		if(!confirm("Etes-vous sûr de vouloir annuler ?")) 
		  			return;
		  		/*let ar = document.querySelectorAll('.save-section');*/
		  		
		  	    let pos = get_index(item, ar); 
		  		let id_parcours = item.dataset.parcours;
		  		let id_episode = item.dataset.episode;
		  		console.log(id_parcours , id_episode);
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

