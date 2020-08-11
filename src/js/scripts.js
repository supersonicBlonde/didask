function get_index(elt, ar_episodes) {
	return Array.prototype.indexOf.call(ar_episodes, elt);
}

function remove_all_modules(ar_blocs) {
	ar_blocs.forEach(item => {
		item.style.display = "none";
	})
}



var callback = function(){
  let ar = document.querySelectorAll('.episodes-item');
  let ar_blocs = document.querySelectorAll('.content-episode');
  let parent_node = document.querySelector('.episodes-list');
 
  document.querySelectorAll('.episodes-item').forEach(item => {
	  item.addEventListener('click', event => {
	  	remove_all_modules(ar_blocs);
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

