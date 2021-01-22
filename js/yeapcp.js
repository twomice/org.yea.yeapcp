/**
 * Custom JS for PCP pages.
 */
CRM.$(function($) {
  // Capture the actual bottom position of the thermometer.
  var el = CRM.$('div.thermometer-pointer');
  var pointerBottom = el.offset().top + el.height();
  // Capture the actual bottom position of the 'X% to goal' message.
  var el = CRM.$('div.thermometer-fill-wrapper');
  var wrapperBottom = el.offset().top + el.height();

  // If '% to goal' message bottom is greater than (positioned lower than) the thermometer,
  // adjust css for the goal message by unsetting 'top' and setting 'bottom: 0px', which will
  // bottom-align the goal message to the thermometer.
  if(pointerBottom > wrapperBottom) {
    CRM.$('div.thermometer-pointer').css({top: 'auto', bottom: '0px'})
  }
});
