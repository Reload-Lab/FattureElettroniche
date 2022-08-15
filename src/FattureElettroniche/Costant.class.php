<?php
/***
 * F5 - Fatture elettroniche
 * 
 * Copyright © 2022
 * Reload - Laboratorio Multimediale
 * (https://www.reloadlab.it - info@reloadlab.it)
 * 
 * authors: Domenico Gigante (domenico.gigante@reloadlab.it)
 ***/

namespace F5\FattureElettroniche;

class Costant {

	// Province italiane
	public static $PI = array( 
		'AG'=>'Agrigento',
		'AL'=>'Alessandria',
		'AN'=>'Ancona',
		'AO'=>'Aosta',
		'AR'=>'Arezzo',
		'AP'=>'Ascoli Piceno',
		'AT'=>'Asti',
		'AV'=>'Avellino',
		'BA'=>'Bari',
		'BT'=>'Barletta-Andria-Trani',
		'BL'=>'Belluno',
		'BN'=>'Benevento',
		'BG'=>'Bergamo',
		'BI'=>'Biella',
		'BO'=>'Bologna',
		'BZ'=>'Bolzano',
		'BS'=>'Brescia',
		'BR'=>'Brindisi',
		'CA'=>'Cagliari',
		'CL'=>'Caltanissetta',
		'CB'=>'Campobasso',
		'CE'=>'Caserta',
		'CT'=>'Catania',
		'CZ'=>'Catanzaro',
		'CH'=>'Chieti',
		'CO'=>'Como',
		'CS'=>'Cosenza',
		'CR'=>'Cremona',
		'KR'=>'Crotone',
		'CN'=>'Cuneo',
		'EN'=>'Enna',
		'FM'=>'Fermo',
		'FE'=>'Ferrara',
		'FI'=>'Firenze',
		'FG'=>'Foggia',
		'FC'=>'Forlì-Cesena',
		'FR'=>'Frosinone',
		'GE'=>'Genova',
		'GO'=>'Gorizia',
		'GR'=>'Grosseto',
		'IM'=>'Imperia',
		'IS'=>'Isernia',
		'SP'=>'La Spezia',
		'AQ'=>'L\'Aquila',
		'LT'=>'Latina',
		'LE'=>'Lecce',
		'LC'=>'Lecco',
		'LI'=>'Livorno',
		'LO'=>'Lodi',
		'LU'=>'Lucca',
		'MC'=>'Macerata',
		'MN'=>'Mantova',
		'MS'=>'Massa-Carrara',
		'MT'=>'Matera',
		'ME'=>'Messina',
		'MI'=>'Milano',
		'MO'=>'Modena',
		'MB'=>'Monza e della Brianza',
		'NA'=>'Napoli',
		'NO'=>'Novara',
		'NU'=>'Nuoro',
		'OR'=>'Oristano',
		'PD'=>'Padova',
		'PA'=>'Palermo',
		'PR'=>'Parma',
		'PV'=>'Pavia',
		'PG'=>'Perugia',
		'PU'=>'Pesaro e Urbino',
		'PE'=>'Pescara',
		'PC'=>'Piacenza',
		'PI'=>'Pisa',
		'PT'=>'Pistoia',
		'PN'=>'Pordenone',
		'PZ'=>'Potenza',
		'PO'=>'Prato',
		'RG'=>'Ragusa',
		'RA'=>'Ravenna',
		'RC'=>'Reggio Calabria',
		'RE'=>'Reggio Emilia',
		'RI'=>'Rieti',
		'RN'=>'Rimini',
		'RM'=>'Roma',
		'RO'=>'Rovigo',
		'SA'=>'Salerno',
		'SS'=>'Sassari',
		'SV'=>'Savona',
		'SI'=>'Siena',
		'SR'=>'Siracusa',
		'SO'=>'Sondrio',
		'SU'=>'Sud Sardegna',
		'TA'=>'Taranto',
		'TE'=>'Teramo',
		'TR'=>'Terni',
		'TO'=>'Torino',
		'TP'=>'Trapani',
		'TN'=>'Trento',
		'TV'=>'Treviso',
		'TS'=>'Trieste',
		'UD'=>'Udine',
		'VA'=>'Varese',
		'VE'=>'Venezia',
		'VB'=>'Verbano-Cusio-Ossola',
		'VC'=>'Vercelli',
		'VR'=>'Verona',
		'VV'=>'Vibo Valentia',
		'VI'=>'Vicenza',
		'VT'=>'Viterbo'
	);
	
	// Regime Fiscale
	public static $RF = array(
		'RF01'=>'Ordinario',
		'RF02'=>'Contribuenti minimi (art. 1, c.96-117, L. 244/2007)',
		'RF04'=>'Agricoltura e attività connesse e pesca (artt. 34 e 34-bis, D.P.R. 633/1972)',
		'RF05'=>'Vendita sali e tabacchi (art. 74, c.1, D.P.R. 633/1972)',
		'RF06'=>'Commercio dei fiammiferi (art. 74, c.1, D.P.R. 633/1972)',
		'RF07'=>'Editoria (art. 74, c.1, D.P.R. 633/1972)',
		'RF08'=>'Gestione di servizi di telefonia (art. 74, c.1, D.P.R. 633/1972)',
		'RF09'=>'Rivendita di documenti di trasporto pubblico e di sosta (art. 74, c.1, D.P.R. 633/1972)',
		'RF10'=>'Intrattenimenti, giochi e altre attività di cui alla tariffa allegata al D.P.R. n. 640/72 (art. 74, c.6, D.P.R. 633/1972)',
		'RF11'=>'Agenzie di viaggi e turismo (art. 74-ter, D.P.R. 633/1972)',
		'RF12'=>'Agriturismo (art. 5, c.2, L. 413/1991)',
		'RF13'=>'Vendite a domicilio (art. 25-bis, c.6, D.P.R. 600/1973)',
		'RF14'=>'Rivendita di beni usati, di oggetti d\'arte, d\'antiquariato o da collezione (art. 36, D.L. 41/1995)',
		'RF15'=>'Agenzie di vendite all\'asta di oggetti d\'arte, antiquariato o da collezione (art. 40-bis, D.L. 41/1995)',
		'RF16'=>'IVA per cassa P.A. (art. 6, c.5, D.P.R. 633/1972)',
		'RF17'=>'IVA per cassa (art. 32-bis, D.L. 83/2012)',
		'RF18'=>'Altro',
		'RF19'=>'Forfettario (art.1, c. 54-89, L. 190/2014)'
	);
	
	// Socio Unico
	public static $SU = array(
		'SU'=>'La società è a socio unico',
		'SM'=>'La società NON è a socio unico'
	);
	
	// Stato Liquidazione
	public static $SL = array(
		'LS'=>'La società è in stato di liquidazione',
		'LN'=>'La società NON è in stato di liquidazione'
	);
	
	// Soggetto Emittente
	public static $SE = array(
		'CC'=>'Cessionario/Committente',
		'TZ'=>'Soggetto terzo'
	);
	
	// Tipo Documento
	public static $TD = array(
		'TD01'=>'Fattura',
		'TD02'=>'Acconto/Anticipo su fattura',
		'TD03'=>'Acconto/Anticipo su parcella',
		'TD04'=>'Nota di Credito',
		'TD05'=>'Nota di Debito',
		'TD06'=>'Parcella',
		'TD16'=>'Integrazione fattura reverse charge interno',
		'TD17'=>'Integrazione/autofattura per acquisto servizi dall\'estero',
		'TD18'=>'Integrazione per acquisto di beni intracomunitari',
		'TD19'=>'Integrazione/autofattura per acquisto di beni ex art.17 c.2 DPR 633/72',
		'TD20'=>'Autofattura per regolarizzazione e integrazione delle fatture (ex art.6 c.8 e 9-bis d.lgs. 471/97 o art.46 c.5 D.L. 331/93)',
		'TD21'=>'Autofattura per splafonamento',
		'TD22'=>'Estrazione beni da Deposito IVA',
		'TD23'=>'Estrazione beni da Deposito IVA con versamento dell\'IVA',
		'TD24'=>'Fattura differita di cui all\'art.21, comma 4, terzo periodo lett. a) DPR 633/72',
		'TD25'=>'Fattura differita di cui all\'art.21, comma 4, terzo periodo lett. b) DPR 633/72',
		'TD26'=>'Cessione di beni ammortizzabili e per passaggi interni (ex art.36 DPR 633/72)',
		'TD27'=>'Fattura per autoconsumo o per cessioni gratuite senza rivalsa'
	);
	
	// Art73
	public static $ART73 = array(
		'SI'=>'Documento emesso secondo modalità e termini stabiliti con DM ai sensi dell\'art. 73 del DPR 633/72'
	);
	
	// Bollo Virtuale
	public static $BV = array(
		'SI'=>'Bollo assolto ai sensi del decreto MEF 14 giugno 2014'
	);
	
	// Ritenuta Cassa
	public static $RTC = array(
		'SI'=>'Contributo cassa soggetto a ritenuta'
	);
	
	// Ritenuta Linea
	public static $RTL = array(
		'SI'=>'Linea di fattura soggetta a ritenuta'
	);
	
	// Ritenuta
	public static $RT = array(
		'SI'=>'Contributo cassa soggetto a ritenuta'
	);
	
	// Tipo Ritenuta
	public static $TR = array(
		'RT01'=>'Ritenuta persone fisiche',
		'RT02'=>'Ritenuta persone giuridiche',
		'RT03'=>'Contributo INPS',
		'RT04'=>'Contributo ENASARCO',
		'RT05'=>'Contributo ENPAM',
		'RT06'=>'Altro contributo previdenziale'
	);
	
	// Tipo Cassa
	public static $TC = array(
		'TC01'=>'Cassa Nazionale Previdenza e Assistenza Avvocati e Procuratori Legali',
		'TC02'=>'Cassa Previdenza Dottori Commercialisti',
		'TC03'=>'Cassa Previdenza e Assistenza Geometri',
		'TC04'=>'Cassa Nazionale Previdenza e Assistenza Ingegneri e Architetti Liberi Professionisti',
		'TC05'=>'Cassa Nazionale del Notariato',
		'TC06'=>'Cassa Nazionale Previdenza e Assistenza Ragionieri e Periti Commerciali',
		'TC07'=>'Ente Nazionale Assistenza Agenti e Rappresentanti di Commercio (ENASARCO)',
		'TC08'=>'Ente Nazionale Previdenza e Assistenza Consulenti del Lavoro (ENPACL)',
		'TC09'=>'Ente Nazionale Previdenza e Assistenza Medici (ENPAM)',
		'TC10'=>'Ente Nazionale Previdenza e Assistenza Farmacisti (ENPAF)',
		'TC11'=>'Ente Nazionale Previdenza e Assistenza Veterinari (ENPAV)',
		'TC12'=>'Ente Nazionale Previdenza e Assistenza Impiegati dell\'Agricoltura (ENPAIA)',
		'TC13'=>'Fondo Previdenza Impiegati Imprese di Spedizione e Agenzie Marittime',
		'TC14'=>'Istituto Nazionale Previdenza Giornalisti Italiani (INPGI)',
		'TC15'=>'Opera Nazionale Assistenza Orfani Sanitari Italiani (ONAOSI)',
		'TC16'=>'Cassa Autonoma Assistenza Integrativa Giornalisti Italiani (CASAGIT)',
		'TC17'=>'Ente Previdenza Periti Industriali e Periti Industriali Laureati (EPPI)',
		'TC18'=>'Ente Previdenza e Assistenza Pluricategoriale (EPAP)',
		'TC19'=>'Ente Nazionale Previdenza e Assistenza Biologi (ENPAB)',
		'TC20'=>'Ente Nazionale Previdenza e Assistenza Professione Infermieristica (ENPAPI)',
		'TC21'=>'Ente Nazionale Previdenza e Assistenza Psicologi (ENPAP)',
		'TC22'=>'INPS'
	);
	
	// Natura
	public static $NT = array(
		'N1'=>'escluse ex art.15 del DPR 633/72',
		'N2.1'=>'non soggette ad IVA ai sensi degli artt. Da 7 a 7-septies del DPR 633/72',
		'N2.2'=>'non soggette – altri casi',
		'N3.1'=>'non imponibili – esportazioni',
		'N3.2'=>'non imponibili – cessioni intracomunitarie',
		'N3.3'=>'non imponibili – cessioni verso San Marino',
		'N3.4'=>'non imponibili – operazioni assimilate alle cessioni all\'esportazione',
		'N3.5'=>'non imponibili – a seguito di dichiarazioni d\'intento',
		'N3.6'=>'non imponibili – altre operazioni che non concorrono alla formazione del plafond',
		'N4'=>'esenti',
		'N5'=>'regime del margine / IVA non esposta in fattura',
		'N6.1'=>'inversione contabile – cessione di rottami e altri materiali di recupero',
		'N6.2'=>'inversione contabile – cessione di oro e argento ai sensi della legge 7/2000 nonché di oreficeria usata ad OPO',
		'N6.3'=>'inversione contabile – subappalto nel settore edile',
		'N6.4'=>'inversione contabile – cessione di fabbricati',
		'N6.5'=>'inversione contabile – cessione di telefoni cellulari',
		'N6.6'=>'inversione contabile – cessione di prodotti elettronici',
		'N6.7'=>'inversione contabile – prestazioni comparto edile e settori connessi',
		'N6.8'=>'inversione contabile – operazioni settore energetico',
		'N6.9'=>'inversione contabile – altri casi',
		'N7'=>'IVA assolta in altro stato UE (prestazione di servizi di telecomunicazioni, tele-radiodiffusione ed elettronici ex art. 7-sexies lett. f, g, art. 74-sexies DPR 633/72)'
	);
	
	// Tipo Sconto Maggiorazione
	public static $TSM = array(
		'SC'=>'Sconto',
		'MG'=>'Maggiorazione'
	);
	
	// Tipo Cessione Prestazione
	public static $TCP = array(
		'SC'=>'Sconto',
		'PR'=>'Premio',
		'AB'=>'Abbuono',
		'AC'=>'Spesa accessoria'
	);
	
	// Esigibilita IVA
	public static $EI = array(
		'I'=>'IVA ad esigibilità immediata',
		'D'=>'IVA ad esigibilità differita',
		'S'=>'Scissione dei pagamenti'
	);
	
	// Condizioni Pagamento
	public static $CP = array(
		'TP01'=>'pagamento a rate',
		'TP02'=>'pagamento completo',
		'TP03'=>'anticipo'
	);
	
	// Condizioni Pagamento
	public static $MP = array(
		'MP01'=>'Contanti',
		'MP02'=>'Assegno',
		'MP03'=>'Assegno circolare',
		'MP04'=>'Contanti presso Tesoreria',
		'MP05'=>'Bonifico',
		'MP06'=>'Vaglia cambiario',
		'MP07'=>'Bollettino bancario',
		'MP08'=>'Carta di pagamento',
		'MP09'=>'RID',
		'MP10'=>'RID utenze',
		'MP11'=>'RID veloce',
		'MP12'=>'Riba',
		'MP13'=>'MAV',
		'MP14'=>'Quietanza erario stato',
		'MP15'=>'Giroconto su conti di contabilità speciale',
		'MP16'=>'Domiciliazione bancaria',
		'MP17'=>'Domiciliazione postale',
		'MP18'=>'Bollettino di c/c postale',
		'MP19'=>'SEPA Direct Debit',
		'MP20'=>'SEPA Direct Debit CORE',
		'MP21'=>'SEPA Direct Debit B2B',
		'MP22'=>'Trattenuta su somme già riscosse',
		'MP23'=>'PagoPA'
	);
}