<?php
namespace CleanCode\Forms;
//Forms immer Formulare ?

//klassenbenamung eindeutig ??
//kein docblock vorhanden - docblock zeigt sich in IDE an
class Rectangle {

    //variablen namen sind nicht sprechend, kann man nicht nachvollziehen
    //initialwerte werden immer im konstruktor überschrieben, dies erhöt unnötig die komplexität
    public $nsd = 5;
    //wird nicht verwendet
    public $ssd = 10;

    //klammern an falscher stelle
    //fehlender docblock
    public function __construct($nsd, $ssd) {
        //keine validierung der werte
        $this->nsd = $nsd;
        //coding standard nicht beachtet( spacing )
        $this->ssd =$ssd;
    }

    /** cooler Berechner für parkettpreis //beinhaltet adjektiv *cool* fügt keinen wert hinzu
     * @param $breite  //fehlende typen
     * @param $laenge
     * @param $typ
     * @return string
     */
    //Methode macht mehr als getParkettPreis  korrekter wäre calculateAreaCalculatePriceAddTaxAndReturnI18NText
    //methode macht zuviel
    public function getParkettPreis($breite,$laenge, $typ) { //klammer nicht einheitlich in PSR 2 standard
        //man könnte parameter in einem objekt zusammenfassen
        $this->nsd = $laenge; //getter setzt wert überschreibt wert im konstruktor
        //formatierung schlecht
        //doppelte verneinung schwierig -unverständliche vergleiche
        //if abfrage evtl in eigene methode auslagern
        //abhängigkeit auf konstanten
        if($typ == 'normal' && null !== !defined('ENV_LAND') || ENV_Land == 'de') {
        //magic numbers für mehrwertsteuer und produktpreis
        //ceil wird durch nicht php entwickler nicht direkt verstanden
        $preis = ceil($this->nsd * $breite ) * 3.99 * 1.19;
            //fest gekodete  übersetzung in Fachklasse
        return "der preis betraegt $preis";
            //typ als text statt konstante, zwei name die gleiche sache edel/luxe
        } elseif ($typ == 'edel'  &&  !defined('ENV_LAND') || ENV_Land == 'de') {
            //block nur schwer erreichbar - bugs easy to hide
            //schwer testbar
        $preis = ceil($this->nsd * $breite ) * 5.99 * 1.19;
        return "der preis betraegt $preis, Edles parkett ist eine gute wahl:";
        }
        //zwei schreibweisen pro if statement
        //ungleiches prinzip für land, einmal ISO, einmal ausgeschrieben
        if($typ == 'normal' && ENV_LAND == 'holland'):
            $preis = ceil($this->nsd * $breite ) * 3.99 * 1.21;
            return "der prijs is $preis";
        elseif ($typ == 'luxe' && ENV_LAND == 'holland'):
            $preis = ceil($this->nsd * $breite ) * 5.99 * 1.21;
            return "der prijs is  $preis, Luxe parkett was een goede keuze";
        endif;

        //mix zwischen scope(innerhalb der funktion gültigen) und klassen variablen
        //viele verzweigungen - schwer zu testen
    }

}