<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Factory\CategoryFactory;
use App\Factory\ExcerciseFactory;
use App\Factory\UserFactory;
use App\Factory\WorkoutKindFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /** @var Category */
        //$mainCat = CategoryFactory::createOne(['name'=>'Reaktywność','final'=>false,'main'=>true])->object();
        //$mainCat1 = CategoryFactory::createOne(['name'=>'Siła','final'=>false,'main'=>true])->object();

        //Loop over all primary elements of the array
        foreach($this->categoryArray as $name => $arr){            
            //Create new category, which will be passed as a parent to all subcategories
            //NOTE: fetching an object is slowing down the fixtures loading 
            $parent = CategoryFactory::createOne(['name'=>$name,'final'=>false,'main'=>true]);
            /** @var Category */
            $parent = $parent->object();
            //Create subcategories recursively
            $this->createSubdirectories($parent,$arr);
        }

        WorkoutKindFactory::createOne(['name' => 'Wstawka Motoryczna']);
        WorkoutKindFactory::createOne(['name' => 'Trening Indywidualny']);
        WorkoutKindFactory::createOne(['name' => 'Trening Grupowy']);
        WorkoutKindFactory::createOne(['name' => 'Program Korekcyjny']);

        UserFactory::createMany(5);
        
        //$categories = CategoryFactory::createMany(5);

        //$excercises = ExcerciseFactory::createMany(10);   


        $manager->flush();
        
    }

    private function createSubdirectories(Category $parent, $arr){
        //If cateogry doesn't have children :
        //its key is becoming next index array and the real name is stored as a value
        foreach($arr as $name => $arr){
            if(is_numeric($name)){
                CategoryFactory::createOne(['name'=>$arr,'final'=>true,'main'=>false])->addParent($parent);
                continue;
            };

            $newParent = CategoryFactory::createOne(['name'=>$name,'final'=>false,'main'=>false]);
            $newParent->addParent($parent);
            /** @var Category */
            $newParent = $newParent->object();
            $this->createSubdirectories($newParent,$arr);
        }
    }

    private $categoryArray = [
        //REAkTYWNOŚĆ
        'Reaktywność' => [
            'Poruszanie liniowe' => [
                'Szybkość'  => ['Przyspieszenie','Podbiegi','Szybkość max','Zbieganie wzniesień','Gamespeed','Prowler','Sanki lub Power  band'],
                'Szybkość - Siła' => [
                    'Wektor horyzontalny' => [
                        'Plyometria' => [
                            'Siła startowa (NCMJ)' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła eksplozywna (CMJ)' =>[
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła reaktywna (Double Contact, Continous,Drop,Jump)' => [
                                'Obunóż', 'Jednonóż'
                            ]
                        ],
                        'Piłki lekarskie' => [
                            'Z zamachem', 'Bez zamachu'
                        ]
                    ],
                    'Wektor wertykalny' => [
                        'Plyometria' => [
                            'Siła startowa (NCMJ)' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła eksplozywna (CMJ)' =>[
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła reaktywna (Double Contact, Continous,Drop,Jump)' => [
                                'Obunóż', 'Jednonóż'
                            ]
                        ],
                        'Piłki lekarskie' => [
                            'Z zamachem', 'Bez zamachu'
                        ]
                    ],
                ],
                'Moc szczytowa' => [
                    'Obciążona plyometria' => [
                        'Wektor wertykalny' => [
                            'Siła startowa (NCMJ)' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła eksplozywna' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła reaktywna (Double Contact, Continous,Drop,Jump)' => [
                                'Obunóż', 'Jednonóż'
                            ]
                        ],
                        'Wektor horyzontalny' => [
                            'Siła startowa (NCMJ)' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła eksplozywna' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła reaktywna (Double Contact, Continous,Drop,Jump)' => [
                                'Obunóż', 'Jednonóż'
                            ]
                        ]
                    ],
                    'Obciążone poruszanie',
                    'Olimpijskie podnoszenie ciężarów -alternatywy',
                    'Olimpijskie podnoszenie ciężarów',
                    'Obciążenie akomodacyjne'
                ],
            ],
            'Poruszanie wielokierunkowe' => [
                'Szybkość' => [
                    'Łagodna zmiana kierunku biegu',
                    'Ostra zmiana kierunku biegu',
                    'Zwinność',
                    'Prowler, sanki lub Power band'
                ],
                'Szybkość - Siła' => [
                    'Plyometria' => [
                        'Kierunek lateralny' => [
                            'Siła startowa (NCMJ)' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła eksplozywna' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła reaktywna (Double Contact, Continous,Drop,Jump)' => [
                                'Obunóż', 'Jednonóż'
                            ]
                        ],
                        'Kierunek rotacyjny' => [
                            'Siła startowa (NCMJ)' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła eksplozywna' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła reaktywna (Double Contact, Continous,Drop,Jump)' => [
                                'Obunóż', 'Jednonóż'
                            ]
                        ]
                    ],
                    'Piłki lekarskie' => [
                        'Z zamachem' => [
                            'Przodem do ściany',
                            'Bokiem do ściany',
                            'O ziemię'
                        ],
                        'Bez zamachu' => [
                            'Przodem do ściany',
                            'Bokiem do ściany'
                        ]
                    ]
                ],
                'Moc szczytowa' => [
                    'Obciążona plyometria' => [
                        'Wektor lateralny' => [
                            'Siła startowa (NCMJ)' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła eksplozywna' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła reaktywna (Double Contact, Continous,Drop,Jump)' => [
                                'Obunóż', 'Jednonóż'
                            ]
                        ],
                        'Wektor rotacyjny' => [
                            'Siła startowa (NCMJ)' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła eksplozywna' => [
                                'Obunóż', 'Jednonóż'
                            ],
                            'Siła reaktywna (Double Contact, Continous,Drop,Jump)' => [
                                'Obunóż', 'Jednonóż'
                            ]
                        ]
                    ],
                    'Obciążone poruszanie',
                    'Olimpijskie podnoszenie ciężarów -alternatywy',
                    'Obciążenie akomodacyjne'
                ],    
            ],
        ],
        'Siła' => [
            'Dół' => [
                'Squat' => [
                    'Nauka Przysiadu',
                    'Obunóż' => [
                        'Skurcz ekscentryczny' => [
                            'Metoda 2:1',
                            'Eccentric overload',
                            'Eccentric isometrics',
                            'Superslow eccentric'
                        ],
                        'Skurcz izometryczny' => [
                            'Pauza',
                            'Overcoming isometrics',
                            'Yielding isometrics',
                            'Stato - dynamic isometrics'
                        ],
                        'Skurcz koncentryczny' => [
                            'Przysiad tylny',
                            'Przysiad przedni',
                            'Przysiad do boxa',
                            'Przysiad kolarski',
                            'Przysiad goblet',
                            'Przysiad Zerchera'
                        ],
                    ],
                    'Jednonóż' => [
                        'Skurcz ekscentryczny' => [
                            'Eccentric isometric',
                            'Slow eccentric',
                            'Absorpcja z podwyższeniem'
                        ],
                        'Skurcz izometryczy' => [
                            'Pauza',
                            'Overcoming isometrics',
                            'Yielding isometrics',
                            'Stato - dynamic isometrics'
                        ],
                        'Skurcz koncentryczny' => [
                            'Przysiad bułgarski',
                            'Przysiad łyżwiarza',
                            'Pistolet',
                            'Przysiad wykroczny',
                            'Wstępowanie przodem',
                            'Wysokie wstępowanie przodem',
                            'Wstępowanie bokiem',
                            'Wysokie wstępowanie bokiem',
                            'Wstępowanie crossoverem',
                            'Wysokie wstępowanie crossoverem',
                            'Wykrok boczny',
                            'Wypad boczny',
                            'Wykrok',
                            'Zakrok',
                            'Zakrok skrzyżny'
                        ]
                    ]
                ],
                'Hinge' => [
                    'Nauka matrwego ciągu',
                    'Obunóż' => [
                        'Skurcz ekscentryczny' => [
                            'Superslow eccentric',
                            'Metoda 2:1'
                        ],
                        'Skorcz izometryczny' => [
                            'Pauza',
                            'Overcoming isometrics',
                            'Stato - dynamic isometrics'
                        ],
                        'Skurcz koncentryczny' => [
                            'Martwy ciąg',
                            'Martwy ciąg sumo',
                            'Rumuński martwy ciąg',
                            'Dzień dobry',
                            'Hip trust',
                            'Glute bridge'
                        ]
                    ],
                    'Jednonóż' => [
                        'Skurcz ekscentryczny' => [
                            'Superslow eccentric',
                            'Metoda 2:1'
                        ],
                        'Skurcz izometryczny' => [
                            'Pauza',
                            'Overcoming isometrics',
                            'Stato - dynamic isometrics'
                        ],
                        'Skurcz koncentryczny' => [
                            'Martwy ciąg w splicie',
                            'Bułgarski hinge',
                            'Jaskółka',
                            'Hip trust jednonóż',
                            'Glute bridge jednonóż'
                        ]
                    ]
                ],
                'Ćwiczenia akcesoryjne' => [
                    'Staw biodrowy' => [
                        'Mm. pośladkowy wielki',
                        'Mm. pośladkowy średni',
                        'Mm. przywodziciele' =>[
                            'Skurcz ekscentryczny',
                            'Skurcz izometryczny',
                            'Skurcz koncentryczny',
                            'Chaos'
                        ],
                        'Mm. biodrowo-lędźwiowy'
                    ],
                    'Staw kolanowy' => [
                        'VMO',
                        'Mm. czworogłowy uda' => [
                            'Skurcz ekscentryczny',
                            'Skurcz izometryczny',
                            'Skurcz koncentryczny',
                            'Chaos'
                        ],
                        'Mm. kulszowo-goleniowe' => [
                            'Skurcz ekscentryczny',
                            'Skurcz izometryczny',
                            'Skurcz koncentryczny',
                            'Chaos'
                        ]
                    ],
                    'Staw skokowy' => [
                        'Mm. trójgłowy łydki',
                        'Mm. brzchaty łydki',
                        'Mm. piszczelowy przedni',
                        'Stopa',
                        'Stabilność statyczna',
                        'Stabilność dynamiczna'
                    ]
                ],
                'Gry i zabawy siłowe'
            ],
            'Góra' => [
                'Push' => [
                    'Pionowy' => [
                        'Oburącz',
                        'Jednorącz'
                    ],
                    'Poziomy' => [
                        'Oburącz',
                        'Jednorącz'
                    ],
                    'Skos' => [
                        'Oburącz',
                        'Jednorącz'
                    ],
                    'Nauka pompki'
                ],
                'Pull' => [
                    'Pionowy' => [
                        'Oburącz',
                        'Jednorącz'
                    ],
                    'Poziomy' => [
                        'Oburącz',
                        'Jednorącz'
                    ],
                    'Skos' => [
                        'Oburącz',
                        'Jednorącz'
                    ],
                    'Nauka podciągania'
                ],
                'Ćwieczenia akcesoryjne' => [
                    'Chwyt',
                    'Staw Łokciowy' => [
                        'Mm. dwugłowy ramienia' => [
                            'Ramię przed tułowiem',
                            'Ramię w linii tułowia',
                            'Ramię za linią tułowia'
                        ],
                        'Mm. trójgłowy ramienia' => [
                            'Ramię nad głową',
                            'Ramię prostopadle do tułowia',
                            'Ramię w linii tułowia',
                        ]
                    ],
                    'Obręcz barkowa' => [
                        'Mm. naramienny - część przednia',
                        'Mm. naramienny - część środkowa',
                        'Mm. naramienny - część tylna',
                        'Stożek rotatorów' => [
                            'Rotacja zewnętrzna',
                            'Rotacja wewnętrzna',
                            'Stabilność statyczna',
                            'Stabilność dynamiczna'
                        ]
                    ],
                    'Łopatka' => [
                        'Mm. czworoboczny grzbietu - część górna',
                        'Mm. czworoboczny - część dolna i środkowa',
                        'Mm. zębaty przedni'
                    ],
                    'Grzbiet' => [
                        'Mm. najszerszy grzbietu',
                        'Mm. prostowniki grzbietu'
                    ],
                    'Klatka piersiowa'
                ],
                'Gry i zabawy siłowe'
            ],
            'Core' => [
                'Anty wyprost' => [
                    'Początkujący',
                    'Średnio zaawansowany',
                    'Zaawansowany'
                ],
                'Anty Rotacja' => [
                    'Początkujący',
                    'Średnio zaawansowany',
                    'Zaawansowany'
                ],
                'Anty zgięcie boczne' => [
                    'Początkujący',
                    'Średnio zaawansowany',
                    'Zaawansowany'
                ],
                'Mm. Prosty brzucha',
                'Mm. skośne brzucha',
                'Gry i zabawy siłowe'
            ],
            'Wytrzymałość' => [
                'Metoda' => [
                    'MAS - PDI',
                    'MAS - ADI',
                    'MAS - PKI',
                    'MAS - AKI',
                    'Gry kondycyjne',
                    'Wytzymałość szybkościowa - krókie sprinty',
                    'Wytzymałość szybkościowa - długie sprinty',
                    'Wytrzymałość mocy',
                    'Interwał ekstentywny',
                    'Interwał intensywny',
                    'Bieg ciągły',
                    'Zabawa biegowa',
                    'Tabata',
                    'Zmodyfikowana tabata',
                    'Obwód stacyjny',
                    'Strumień',
                    'Kompleksy sztangowe',
                    'Trening strongmana',
                    'AMRAP',
                    'EMOM',
                    'Time goal',
                    'Rep goal',
                    'Symulacja treningu wysokogórskiego',
                    'Twot'
                ],
                'Intensywność' => [
                    '80% MAS',
                    '85% MAS',
                    '90% MAS',
                    '95% MAS',
                    '100% MAS',
                    '105% MAS',
                    '110% MAS',
                    '115% MAS',
                    '120% MAS',
                    '125% MAS',
                    '130% MAS',
                    '3,4 m/s',
                    '3,6 m/s',
                    '3,8 m/s',
                    '4,0 m/s',
                    '4,2 m/s',
                    '4,4 m/s',
                    '4,6 m/s',
                    '4,8 m/s',
                    '5,0 m/s',
                    'Max.',
                    'Sprint',
                    'Tlenowa regeneracyjna 60-75 % HR max.',
                    'Podprogowa: 75 - 85 % HR max.',
                    'Progowa: 85 % HR max.',
                    'Beztlenowa mleczanowa 85 - 100 % HR max.'
                ]
            ],
        ],
        'Rozgrzewka' => [
            'Forma' => [
                'Zabawa ożywiająca',
                'Rozciąganie dynamiczne',
                'RAMP',
                'MAP',
                'Poruszanie liniowe',
                'Poruszanie wielokierunkowe',
                'Poruszanie slalomem',
                'Poruszanie po czworokącie',
                'Schemat podań',
                'W 2 rzędach',
                'W 4 rzędach',
                'Każdy z piłką',
                'W parach',
                'W parach - 1 piłka',
                'W parach - 2 piłki',
                'W trójkach - 2 piłki',
                'Obwód ruchowy',
                'Drabinka koordynacyjna',
                'Płotki lekkoatletyczne',
                'Niskie płotki',
                'Grzybki',
                'Pachołki',
                'Mini band',
                'Power band',
                'Laska gimnastyczna',
                'Piłka szwajcarska',
                'Stepy',
                'Piłka tenisowa',
                'Skakanka',
                'Animal movement',
                'Gry i zabawy z mocowaniem',
                'Koordynacja ruchowa',
                'Gimnastyka i akrobatyka',
                'Gimnastyka i akrobatyka w parach',
                'Fundamentalne umiejętności ruchowe - sprawność ogólna',
                'Integracja ruchowa',
                'Zadanie na komendę'
            ]
        ],
        'Prewencja urazów' => [
            'Staw biodrowy' => [
                'Mm. pośladkowy wielki',
                'Mm. pośladkowy średni',
                'Mm. przywodziciele' =>[
                    'Skurcz ekscentryczny',
                    'Skurcz izometryczny',
                    'Skurcz koncentryczny',
                    'Chaos'
                ],
                'Mm. biodrowo-lędźwiowy'
            ],
            'Staw kolanowy' => [
                'VMO',
                'Mm. czworogłowy uda' => [
                    'Skurcz ekscentryczny',
                    'Skurcz izometryczny',
                    'Skurcz koncentryczny',
                    'Chaos'
                ],
                'Mm. kulszowo-goleniowe' => [
                    'Skurcz ekscentryczny',
                    'Skurcz izometryczny',
                    'Skurcz koncentryczny',
                    'Chaos'
                ]
            ],
            'Staw skokowy' => [
                'Mm. trójgłowy łydki',
                'Mm. brzchaty łydki',
                'Mm. piszczelowy przedni',
                'Stopa',
                'Stabilność statyczna',
                'Stabilność dynamiczna'
            ],
            'Chwyt',
            'Staw Łokciowy' => [
                'Mm. dwugłowy ramienia' => [
                    'Ramię przed tułowiem',
                    'Ramię w linii tułowia',                        'Ramię za linią tułowia'
                ],
                'Mm. trójgłowy ramienia' => [
                    'Ramię nad głową',                        'Ramię prostopadle do tułowia',
                    'Ramię w linii tułowia',
                    ]
                ],
            'Obręcz barkowa' => [
               'Mm. naramienny - część przednia',
               'Mm. naramienny - część środkowa',
               'Mm. naramienny - część tylna',
                'Stożek rotatorów' => [
                    'Rotacja zewnętrzna',
                    'Rotacja wewnętrzna',
                    'Stabilność statyczna',
                    'Stabilność dynamiczna'
                   ]
            ],
            'Łopatka' => [
                'Mm. czworoboczny grzbietu - część górna',
                'Mm. czworoboczny - część dolna i środkowa',
                'Mm. zębaty przedni'
            ],
            'Grzbiet' => [
                'Mm. najszerszy grzbietu',
                'Mm. prostowniki grzbietu'
            ],
            'Klatka piersiowa',
            'Core' => [
                'Anty wyprost' => [
                    'Początkujący',
                    'Średnio zaawansowany',
                    'Zaawansowany'
                ],
                'Anty Rotacja' => [
                    'Początkujący',
                    'Średnio zaawansowany',
                    'Zaawansowany'
                ],
                'Anty zgięcie boczne' => [
                    'Początkujący',
                    'Średnio zaawansowany',
                    'Zaawansowany'
                ],
                'Mm. Prosty brzucha',
                'Mm. skośne brzucha',
            ]
        ],
        'Program korekcyjny' => [
            'Rolowanie',
            'Mobilizacja' => [
                'Staw skokowy' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                    'Palis & Rails',
                    'Loaded stretch',
                ],
                'Mm. zginacze bioder' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                    'Loaded stretch'
                ],
                'Mm. kulszowo-goleniowe' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                    'Palis & Rails',
                    'Loaded stretch',
                ],
                'Mm. przywodziciele' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                    'Palis & Rails',
                    'Loaded stretch',
                ],
                'Mm. pośladkowe' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                ],
                'Staw biodrowy' => [
                    'Rotacje bioder - stretching aktywny',
                    "Globalnie - Car's",
                ],
                'Mm. brzucha' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                ],
                'Kręgosłup piersiowy' => [
                    'Wyprost w kręgosłupie piersiowym - stretching aktywny',
                    'Rotacje w kręgosłupie piersiowym - stretching aktywny'
                ],
                'Mm. klatki piersiowej' => [
                    'Stretching statyczny',
                    'Palis & Rails',
                    'Loaded stretch',
                ],
                'Mm. najszerszy grzbietu' => [
                    'Stretching statyczny', 
                    'Pails & Rails',
                ],
                'Staw ramienny' => [
                    'Zgięcie w stawie ramiennym - stretching akywny',
                    'Wyprost w stawie ramiennym - stretching akywny',
                    'Rotacje w stawie ramiennym - stretching akywny',
                    "Globalnie - CAR's"
                ],
                'Integracja ruchowa',
                'Animal movement'
            ],
            'Aktywizacja' => [
                'Mm. pośladkowy wielki',
                'Mm. pośladkowy średni',
                'Mm. pośladkowy lędźwiowy',
                'Mm. biodrowo-lędźwiowy',
                'VMO',
                'Mm. piszczelowy przedni',
                'Stopa',
                'Staw skokowy - stabilność statyczna',
                'Staw skokowy - stabilność dynamiczna',
                'Mm. naramienny - część tylnia',
                'Stożek rotatorów' => [
                    'Rotacja zewnętrzna',
                    'Rotacja wewnętrzna',
                    'Stabilność statyczna',
                    'Stabilność dynamiczna',
                ],
                'Mm. czworoboczny - część dolna i środkowa',
                'Mm. zębaty przedni',
                'Core' => [
                    'Anty wyprost' => [
                        'Początkujący',
                        'Średnio zaawansowany',
                        'Zaawansowany'
                    ],
                    'Anty Rotacja' => [
                        'Początkujący',
                        'Średnio zaawansowany',
                        'Zaawansowany'
                    ],
                    'Anty zgięcie boczne' => [
                        'Początkujący',
                        'Średnio zaawansowany',
                        'Zaawansowany'
                    ],
                ]
            ]
        ],
        'Przygotowanie ruchowe' => [
            'Rolowanie',
            'Podniesienie temperatury ciała',
            'Mobilizacja' => [
                'Staw skokowy' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                    'Palis & Rails',
                    'Loaded stretch',
                ],
                'Mm. zginacze bioder' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                    'Loaded stretch'
                ],
                'Mm. kulszowo-goleniowe' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                    'Palis & Rails',
                    'Loaded stretch',
                ],
                'Mm. przywodziciele' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                    'Palis & Rails',
                    'Loaded stretch',
                ],
                'Mm. pośladkowe' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                ],
                'Staw biodrowy' => [
                    'Rotacje bioder - stretching aktywny',
                    "Globalnie - Car's",
                ],
                'Mm. brzucha' => [
                    'Stretching statyczny',
                    'Stretching aktywny',
                ],
                'Kręgosłup piersiowy' => [
                    'Wyprost w kręgosłupie piersiowym - stretching aktywny',
                    'Rotacje w kręgosłupie piersiowym - stretching aktywny'
                ],
                'Mm. klatki piersiowej' => [
                    'Stretching statyczny',
                    'Palis & Rails',
                    'Loaded stretch',
                ],
                'Mm. najszerszy grzbietu' => [
                    'Stretching statyczny', 
                    'Pails & Rails',
                ],
                'Staw ramienny' => [
                    'Zgięcie w stawie ramiennym - stretching akywny',
                    'Wyprost w stawie ramiennym - stretching akywny',
                    'Rotacje w stawie ramiennym - stretching akywny',
                    "Globalnie - CAR's"
                ],
                'Integracja ruchowa',
                'Animal movement'
            ],
            'Aktywizacja' => [
                'Mm. pośladkowy wielki',
                'Mm. pośladkowy średni',
                'Mm. pośladkowy lędźwiowy',
                'Mm. biodrowo-lędźwiowy',
                'VMO',
                'Mm. piszczelowy przedni',
                'Stopa',
                'Staw skokowy - stabilność statyczna',
                'Staw skokowy - stabilność dynamiczna',
                'Mm. naramienny - część tylnia',
                'Stożek rotatorów' => [
                    'Rotacja zewnętrzna',
                    'Rotacja wewnętrzna',
                    'Stabilność statyczna',
                    'Stabilność dynamiczna',
                ],
                'Mm. czworoboczny - część dolna i środkowa',
                'Mm. zębaty przedni',
                'Core' => [
                    'Anty wyprost' => [
                        'Początkujący',
                        'Średnio zaawansowany',
                        'Zaawansowany'
                    ],
                    'Anty Rotacja' => [
                        'Początkujący',
                        'Średnio zaawansowany',
                        'Zaawansowany'
                    ],
                    'Anty zgięcie boczne' => [
                        'Początkujący',
                        'Średnio zaawansowany',
                        'Zaawansowany'
                    ],
                ]
            ],
            'Technika poruszania' => [
                'Poruszanie liniowe' => [
                    'Pozycja',
                    'Wzorzec',
                    'Intensyfikacja',
                    'Absorpcja energii' => [
                        'Technika lądowania',
                        'Technika hamowania'
                    ],
                    'Bieg tyłem' => [
                        'Bez akcji głowy',
                        'Z akcją głowy'
                    ],
                ],
                'Poruszanie wielokierunkowe' => [
                    'Lateralnie' => [
                        'Pozycja',
                        'Wzorzec',
                        'Intensyfikacja',
                    ],
                    'Rotacyjnie' => [
                        'Pozycja',
                        'Wzorzec',
                        'Intensyfikacja',
                    ],
                    'Absorpcja energii' => [
                        'Technika lądowania',
                        'Technika hamowania'
                    ]
                ]
            ]
        ]

    ];
}
