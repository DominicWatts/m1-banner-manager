<?php

/**
 * Banner Manager frontend controller
 *
 * @author Xigen
 */
class Xigen_Bannermanager_IndexController extends Xigen_Bannermanager_Controller_Abstract {

    /**
     * Pre dispatch action that allows to redirect to no route page in case of disabled extension through admin panel
     */
    public function preDispatch() {
        parent::preDispatch();
    }

}
