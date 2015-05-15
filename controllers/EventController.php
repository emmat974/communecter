<?php
/**
 * EventController.php
 *
 * tous ce que propose le PH en terme de gestion d'evennement
 *
 * @author: Tibor Katelbach <tibor@pixelhumain.com>
 * Date: 15/08/13
 */
class EventController extends CommunecterController {
    const moduleTitle = "Évènement";
    
  protected function beforeAction($action) {
    parent::initPage();
    return parent::beforeAction($action);
  }
  public function actions()
  {
      return array(
          'edit'          => 'citizenToolKit.controllers.event.SaveAttendees',
          'saveattendees' => 'citizenToolKit.controllers.event.DashboardAction',
          'save'          => 'citizenToolKit.controllers.event.SaveAction',
          'getcalendar'   => 'citizenToolKit.controllers.event.GetCalendarAction',
          'delete' => 'citizenToolKit.controllers.event.DeleteAction',
      );
  }
}