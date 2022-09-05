function switchTab(tabname){
  document.cookie = "activetab="+tabname;
  var pages = document.getElementsByClassName("tab_page");
  for (var i = 0; i < pages.length; i++){
    pages[i].style.display = "none";
  }
  document.getElementById(tabname).style.display = "block";
}

function pick_rpd(e){
  rpd_id = e.value;
  if (isNaN(rpd_id)){
    rpd_id = 0;
  }
  document.cookie = "rpd_id="+rpd_id;
  document.cookie = "select_id="+e.selectedIndex;
  location.reload();
}

function autoselectTab(){
  if (document.cookie.includes("activetab")){
    switchTab(document.cookie.split("activetab=")[1].split(";")[0]);
  }
}

function autoselectRpd(){
  if (document.cookie.includes("select_id")){
    var s = document.getElementById("select_rpd");
    for (var i=0; i < s.options.length; i++){
      need_id = document.cookie.split("select_id=")[1].split(";")[0];
      if (i == need_id){
        document.getElementById("select_rpd").selectedIndex = need_id;
      }
    }
  }
}

function cleanupTables(){
  tables = document.querySelectorAll('#db_table table');
  tables.forEach((table1, index1) => {
    tables.forEach((table2, index2) => {
      if (index2 > index1){
        var div = table2.parentNode;
        if ((table1.attributes.id.value == table2.attributes.id.value) && (div.parentNode != null)){
          console.log("dupe");
          table2.tBodies[0].childNodes.forEach((row, index, object) => {
            var dupe = false;
            rows1 = table1.tBodies[0].childNodes;
            for(var r=0; r<rows1.length; r++){
              if(rows1[r].outerHTML == row.outerHTML){
                dupe = true;
              }
            }
            if (dupe == false){
              table1.tBodies[0].appendChild(row.cloneNode(true));
            }
          });
          div.parentNode.removeChild(div);
        }
      }
    });
  });
}

function collapse(elem){
  var div = elem.nextSibling.nextSibling;
  var st = window.getComputedStyle(div);
  if (st.getPropertyValue("Display") == "block"){
    div.style.display = "none";
    elem.innerText = "Развернуть";
  } else {
    div.style.display = "block";
    elem.innerText = "Свернуть";
  }
}

function getvalues(table, column, target){
  document.querySelectorAll(table+' tr th').forEach((col, index) => {
    if(col.innerText == column){
      var sel = table+' tr:nth-child(1) td:nth-child('+(index+1).toString()+')';
      profile = document.querySelector(sel).innerText;
      document.querySelectorAll(target).forEach(node => {
        if (node.localName == "input"){
          node.value = profile;
        } else {
          node.innerText = profile;
        }
      });
    }
  });
}