/**
 * Custom JS for PCP pages.
 */
CRM.$(function($) {
  // Capture the actual bottom position of the thermometer.
  var elPointer = CRM.$('div.thermometer-pointer');
  var pointerBottom = elPointer.offset().top + elPointer.height();

  // Capture the actual bottom position of the 'X% to goal' message.
  var elWrapper = CRM.$('div.thermometer-fill-wrapper');
  var wrapperBottom = elWrapper.offset().top + elWrapper.height();

  // If '% to goal' message bottom is greater than (positioned lower than) the thermometer,
  // adjust css for the goal message by unsetting 'top' and setting 'bottom: 0px', which will
  // bottom-align the goal message to the thermometer.
  if(pointerBottom > wrapperBottom) {
    CRM.$('div.thermometer-pointer').css({top: 'auto', bottom: '0px'});
  }
});
