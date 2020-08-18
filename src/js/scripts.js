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
	  	console.log(window.getComputedStyle(item, ':after'));
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

};

if (
    document.readyState === "complete" ||
    (document.readyState !== "loading" && !document.documentElement.doScroll)
) {
  callback();
} else {
  document.addEventListener("DOMContentLoaded", callback);
}

