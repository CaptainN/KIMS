$(document).ready(function() {
   // look for students with similar last names to avoid dupes
   $alert = $("<div>").addClass("alert alert-warning").hide().appendTo("#alerts");
   $("#student-lname").keyup(function() {
      var term = this.value;
      if (term.length > 2) {
         $.get(options.checkNameUrl, {term: term})
          .done(function(response) {
             $alert.html(response);
             if (response.length)
             {
                $alert.show();
             }
             else
             {
                $alert.hide();
             }
          });
      }
   });

   // populate hand anchors when division changes
   $("#student-division_id").change(function() {
      var div = this.value;
      var $list = $("#student-handanchor");
      $.getJSON(options.getClassesUrl, {division_id: div}, function(json) {
         $list.html(' ');
         $.each(json, function(idx, obj)
         {
            var option = $('<option />').val(obj.value).text(obj.text);
            console.log(option);
            $list.append(option);
         });
      });
   });
});