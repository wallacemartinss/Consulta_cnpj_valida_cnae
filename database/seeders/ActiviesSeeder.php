<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActiviesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('permitted_activities')->delete();
        $states = array(

            array('id' => 1, 'name' => "02-9/00", 'description' => "Atividades relacionadas a esgoto, exceto a gestão de redes"),
            array('id' => 2, 'name' => "4120-4/00", 'description' => "Construção de edifícios"),
            array('id' => 3, 'name' => "844077", 'description' => "Construção de rodovias e ferrovias"),
            array('id' => 4, 'name' => "4213-8/00", 'description' => "Obras de urbanização – ruas, praças e calçadas"),
            array('id' => 5, 'name' => "847973", 'description' => "Construção de barragens e represas para geração de energia elétrica"),
            array('id' => 6, 'name' => "847974", 'description' => "Construção de estações e redes de distribuição de energia elétrica"),
            array('id' => 7, 'name' => "847976", 'description' => "Construção de estações e redes de telecomunicações"),
            array('id' => 8, 'name' => "848276", 'description' => "Construção de redes de abastecimento de água, coleta de esgoto e construções correlatas, exceto obras de irrigação."),
            array('id' => 9, 'name' => "848277", 'description' => "Obras de irrigação"),
            array('id' => 10, 'name' => "4223-5/00", 'description' => "Construção de redes de transportes por dutos, exceto para água e esgoto"),
            array('id' => 11, 'name' => "4291-0/00", 'description' => "Obras portuárias, marítimas e fluviais"),
            array('id' => 12, 'name' => "873875", 'description' => "Montagem de estruturas metálicas"),
            array('id' => 13, 'name' => "873876", 'description' => "Obras de montagem industrial"),
            array('id' => 14, 'name' => "876339", 'description' => "Construção de instalações esportivas e recreativas"),
            array('id' => 15, 'name' => "4299-5/99", 'description' => "Outras obras de engenharia civil não especificada anteriormente"),
            array('id' => 16, 'name' => "880813", 'description' => "Demolição de edifícios e outras estruturas"),
            array('id' => 17, 'name' => "880814", 'description' => "Preparação de canteiro e limpeza de terreno"),
            array('id' => 18, 'name' => "4312-6/00", 'description' => "Perfurações e sondagens"),
            array('id' => 19, 'name' => "4313-4/00", 'description' => "Obras de terraplenagem"),
            array('id' => 20, 'name' => "4319-3/00", 'description' => "Serviços de preparação do terreno não especificados anteriormente"),
            array('id' => 21, 'name' => "4321-5/00", 'description' => "Instalação e manutenção elétrica"),
            array('id' => 22, 'name' => "884678", 'description' => "Instalações hidráulicas, sanitárias e de gás"),
            array('id' => 23, 'name' => "887631", 'description' => "Impermeabilização em obras de engenharia civil"),
            array('id' => 24, 'name' => "887632", 'description' => "Instalação de portas, janelas, tetos, divisórias e armários embutidos de qualquer material"),
            array('id' => 25, 'name' => "887633", 'description' => "Obras de acabamento em gesso e estuque"),
            array('id' => 26, 'name' => "887634", 'description' => "Serviços de pintura de edifícios em geral"),
            array('id' => 27, 'name' => "887635", 'description' => "Aplicação de revestimentos e de resinas em interiores e exteriores"),
            array('id' => 28, 'name' => "4330-4/99", 'description' => "Outras obras de acabamento da construção"),
            array('id' => 29, 'name' => "4391-6/00", 'description' => "Obras de fundações"),  
            array('id' => 30, 'name' => "912745", 'description' => "Obras de alvenaria"),
            array('id' => 31, 'name' => "912747", 'description' => "Perfuração e construção de poços de água"),
            array('id' => 32, 'name' => "4399-1/99", 'description' => "Serviços especializados para construção não especificados anteriormente"),
            array('id' => 33, 'name' => "1830413", 'description' => "Serviços advocatícios"),
            array('id' => 34, 'name' => "2012520", 'description' => "Design de interiores"),
            array('id' => 35, 'name' => "2231999", 'description' => "Atividades de vigilância e segurança privada"),
            array('id' => 36, 'name' => "8012-9/00", 'description' => "Atividades de transporte de valores"),
            array('id' => 37, 'name' => "8020-0/00", 'description' => "Atividades de monitoramento de sistemas de segurança"),
            array('id' => 38, 'name' => "8020-0/01", 'description' => "Atividades de monitoramento de sistemas de segurança eletrônico"),
            array('id' => 39, 'name' => "8020-0/02", 'description' => "Outras atividades de serviços de segurança"),
            array('id' => 40, 'name' => "8111-7/00", 'description' => "Serviços combinados para apoio a edifícios, exceto condomínios prediais"),
            array('id' => 41, 'name' => "8121-4/00", 'description' => "Limpeza em prédios e em domicílios"),
            array('id' => 42, 'name' => "8122-2/00", 'description' => "Imunização e controle de pragas urbanas"),
            array('id' => 43, 'name' => "8129-0/00", 'description' => "Atividades de limpeza não especificadas anteriormente"),
            array('id' => 44, 'name' => "8130-3/00", 'description' => "Atividades paisagísticas"),
            array('id' => 45, 'name' => "9700-5/00", 'description' => "Serviços domésticos"),
            array('id' => 46, 'name' => "9900-8/00", 'description' => "Organismos internacionais e outras instituições extraterritoriais"),
        );
        DB::table('permitted_activities')->insert($states);
    }
}