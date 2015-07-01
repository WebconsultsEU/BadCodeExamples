<?php
namespace CleanCode\Forms;

class Rectangle {


    //wird wieder überschrieben
    //benamung nicht eindeutig
    public $nsd = 5;
    public $ssd = 10;

    public function __construct($nsd, $ssd) {
        $this->nsd = $nsd;
        $this->ssd =$ssd;
    }

    /** Berechner für parkettpreis
     * @param $breite
     * @param $laenge
     * @param $typ
     * @return string
     */

    //keine typehints
    public function getParkettPreis($breite,$laenge, $typ) {
        $this->nsd = $laenge;

        if($typ == 'normal' && null !== !defined('ENV_LAND') || ENV_Land == 'de') {
        $preis = ceil($this->nsd * $breite ) * 3.99 * 1.19;
        return "der preis betraegt $preis";
        } elseif ($typ == 'edel'  &&  !defined('ENV_LAND') || ENV_Land == 'de') {
        $preis = ceil($this->nsd * $breite ) * 5.99 * 1.19;
        return "der preis betraegt $preis, Edles parkett ist eine gute wahl:";
        }
        if($typ == 'normal' && ENV_LAND == 'holland'):
            $preis = ceil($this->nsd * $breite ) * 3.99 * 1.21;
            return "der prijs is $preis";
        elseif ($typ == 'luxe' && ENV_LAND == 'holland'):
            //variablen im code eingesetz
            $preis = ceil($this->nsd * $breite ) * 5.99 * 1.21;
            return "der prijs is  $preis, Luxe parkett was een goede keuze";
        endif;
    }
    //muss für neue typen angepasst werden
    //if bedingungen kompliziert
    //2 if hat keine klammern
    //globale konstanten -macht es schwer testbar
    // -get partkettpreis nicht eindeutig und gibt text wieder
    //copy & pased
    //keine code styles
}