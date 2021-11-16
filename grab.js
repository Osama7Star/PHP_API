var forms = document.forms;

// add an event listener to the submit event for every form in the page
for (index = 0; index < forms.length; ++index){
  if(forms[index].getAttribute("data-formid") === 'db29a442-b71c-4e72-8e82-d742d5cc92f6' || forms[index].getAttribute("data-formid") === '48d80fc1-7247-49e3-a857-037a2064f8be')
    forms[index].addEventListener('submit', formSubmit);
}

//called when a submit event happens
function formSubmit(event){
  console.log('start saving form data');
  var list = {};
    for (index = 0; index < event.target.elements.length; ++index){
        if(event.target.elements[index].name === 'Branch'){          
          list[event.target.elements[index].name] = $.trim($("#Branch option:selected").text());
        }else{
          list[event.target.elements[index].name] = event.target.elements[index].value;
        }
    }

    var mydata  = {
      items: list,      
    }

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "http://clinc.htc-nablus.com/api/web/v1/recipes/form?access-token=test&lang=ar",
      data: mydata,
      success: function(data){
          console.log(data);
      },
      error: function(xhr, textStatus, errorThrown){
        // alert(textStatus);
      }
    });
}