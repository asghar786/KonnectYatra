$(document).ready(function(){
 
    var filter=document.getElementById('filterbtn');
    var div=document.getElementById('filterdiv');
  
      var a=0;
      div.style.display='none'  
  
    $(filter).click(function(){
        if(a==0){
            div.style.display='block';
              return a=1;
        }
        else{
            div.style.display='none';
            return a=0;
        }
    });
  
     $('#clear').click(function(){
          document.getElementById('name').value='';
          document.getElementById('city').value='';
          document.getElementById('email').value='';
          document.getElementById('number').value='';
        
     });
     $('#search').click(function(){
     var name=document.getElementById('name').value.toUpperCase();
     var city=document.getElementById('city').value.toUpperCase();
     var email=document.getElementById('email').value.toUpperCase();
     var licensenumber=document.getElementById('number').value.toUpperCase();
  
     $('#mytable tr').filter(function(){
       $(this).toggle(($(this).text().toUpperCase().indexOf(name) > -1) && ( $(this).text().toUpperCase().indexOf(city) > -1) && ( $(this).text().toUpperCase().indexOf(email) > -1) &&  ( $(this).text().toUpperCase().indexOf(licensenumber) > -1))
     });
     
 });
     

  });