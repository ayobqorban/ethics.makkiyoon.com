
// Reviews step by step in car program
const wizardVertical = document.querySelector(".wizard-vertical");

if (typeof wizardVertical !== undefined && wizardVertical !== null) {
  const wizardVerticalBtnNextList = [].slice.call(wizardVertical.querySelectorAll('.btn-next')),
    wizardVerticalBtnPrevList = [].slice.call(wizardVertical.querySelectorAll('.btn-prev')),
    wizardVerticalBtnSubmit = wizardVertical.querySelector('.btn-submit');

  const numberedVerticalStepper = new Stepper(wizardVertical, {
    linear: false
  });
  if (wizardVerticalBtnNextList) {
    wizardVerticalBtnNextList.forEach(wizardVerticalBtnNext => {
      wizardVerticalBtnNext.addEventListener('click', event => {
        numberedVerticalStepper.next();
      });
    });
  }
  if (wizardVerticalBtnPrevList) {
    wizardVerticalBtnPrevList.forEach(wizardVerticalBtnPrev => {
      wizardVerticalBtnPrev.addEventListener('click', event => {
        numberedVerticalStepper.previous();
      });
    });
  }
  if (wizardVerticalBtnSubmit) {
    wizardVerticalBtnSubmit.addEventListener('click', event => {
      alert('Submitted..!!');
    });
  }
}









$('.full-star-ratings').rateYo({
    rating: 5
  });


  // Form Repeater
// ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
// -----------------------------------------------------------------------------------------------------------------
var formRepeater = $(".form-repeater");

var row = 2;
var col = 1;
formRepeater.on('submit', function(e) {
  e.preventDefault();
});
formRepeater.repeater({
  show: function() {
    var fromControl = $(this).find('.form-control, .form-select');
    var formLabel = $(this).find('.form-label');

    fromControl.each(function(i) {
      var id = 'form-repeater-' + row + '-' + col;
      $(fromControl[i]).attr('id', id);
      $(formLabel[i]).attr('for', id);
      col++;
    });

    row++;

    $(this).slideDown();
  },
  hide: function(e) {
    confirm('Are you sure you want to delete this element?') && $(this).slideUp(e);
  }
});


// Date
$("#bs-rangepicker-basic").daterangepicker();
$("#bs-datepicker-autoclose").datepicker({ autoclose: true });

var flatpickrDate = document.querySelector(".flatpickr-date");
// flatpickrDate.flatpickr({
//   monthSelectorType: "static"
// });


picker('votingform_start');
picker('votingform_end');

function picker(id_picker){
    var flatpickrDate = document.querySelector("#"+id_picker);
    flatpickrDate.flatpickr({
      monthSelectorType: "static"
    });
}



// create new account

$(".select2").select2();


// if checked main checkbox to checked all groups checkbox
function toggle_permission_maintenance() {

    var mainCheckbox = document.querySelector('.check_main_maintenance');
    var checkboxes = document.querySelectorAll('.permission_maintenance_checkgroups input[type="checkbox"]');

    checkboxes.forEach(function(checkbox) {
        checkbox.checked = mainCheckbox.checked;
    });
}


























