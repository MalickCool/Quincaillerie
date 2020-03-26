<script>
window.onload=calcule

var res, plus, diz, s, un, mil, mil2, ent, deci, centi, pl, pl2, conj;

var t=["","Un","Deux","Trois","Quatre","Cinq","Six","Sept","Huit","Neuf"];
var t2=["Dix","Onze","Douze","Treize","Quatorze","Quinze","Seize","Dix-sept","Dix-huit","Dix-neuf"];
var t3=["","","Vingt","Trente","Quarante","Cinquante","Soixante","Soixante","Quatre-vingt","Quatre-vingt"];


function calcule(){
    document.getElementById("montPh").onchange=function(){
        document.getElementById('lettre').value=trans(this.value)+" F CFA";
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des deux parties du nombre;
function decint(n){

    switch(n.length){
        case 1 : return dix(n);
        case 2 : return dix(n);
        case 3 : return cent(n.charAt(0)) + " " + decint(n.substring(1));
        default: mil=n.substring(0,n.length-3);
            if(mil.length<4){
                un= (mil==1) ? "" : decint(mil);
                return un + mille(mil)+ " " + decint(n.substring(mil.length));
            }
            else{
                mil2=mil.substring(0,mil.length-3);
                return decint(mil2) + million(mil2) + " " + decint(n.substring(mil2.length));
            }
    }
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des nombres entre 0 et 99, pour chaque tranche de 3 chiffres;
function dix(n){
    if(n<10){
        return t[parseInt(n)]
    }
    else if(n>9 && n<20){
        return t2[n.charAt(1)]
    }
    else {
        plus= n.charAt(1)==0 && n.charAt(0)!=7 && n.charAt(0)!=9 ? "" : (n.charAt(1)==1 && n.charAt(0)<8) ? " et " : "-";
        diz= n.charAt(0)==7 || n.charAt(0)==9 ? t2[n.charAt(1)] : t[n.charAt(1)];
        s= n==80 ? "s" : "";

        return t3[n.charAt(0)] + s + plus + diz;
    }
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des mots "cent", "mille" et "million"
function cent(n){
    return n>1 ? t[n]+ " Cent" : (n==1) ? " Cent" : "";
}

function mille(n){
    return n>=1 ? " Mille" : "";
}

function million(n){
    return n>=1 ? " Millions" : " Million";
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// conversion du nombre
function trans(n){

    // vérification de la valeur saisie
    if(!/^\d+[.,]?\d*$/.test(n)){
        return ""
    }

    // séparation entier + décimales
    n=n.replace(/(^0+)|(\.0+$)/g,"");
    n=n.replace(/([.,]\d{2})\d+/,"$1");
    n1=n.replace(/[,.]\d*/,"");
    n2= n1!=n ? n.replace(/\d*[,.]/,"") : false;

    // variables de mise en forme
    ent= !n1 ? "" : decint(n1);
    deci= !n2 ? "" : decint(n2);
    if(!n1 && !n2){
        return  "Entrez une valeur non nulle!"
    }
    conj= !n2 || !n1 ? "" : "  et ";
    euro= !n1 ? "" : !/[23456789]00$/.test(n1) ? "" : "";
    centi= !n2 ? "" : " centime";
    pl=  n1>1 ? "" : "";
    pl2= n2>1 ? "" : "";

    // expression complète en toutes lettres
    return (" " + ent + euro + pl + conj + deci + centi + pl2).replace(/\s+/g," ").replace("cent s E","cents E") ;
}
</script>