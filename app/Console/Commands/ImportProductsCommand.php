<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use GuzzleHttp\Client;

class ImportProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--id= : ID do produto externo a ser importado}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa produtos de uma API externa para o banco de dados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->option('id');

        if ($id) {
            $this->importSingleProduct($id);
        } else {
            $this->importAllProducts();
        }

        return 0;
    }

    /**
     * Importa todos os produtos da API externa
     *
     * @return void
     */
    private function importAllProducts()
    {
        $url = 'https://fakestoreapi.com/products';

        $client = new Client();
        $response = $client->get($url);

        if ($response->getStatusCode() == 200) {
            $products = json_decode($response->getBody(), true);
            $importedCount = 0; // Variável contador

            foreach ($products as $productData) {
                if ($this->saveProduct($productData)) {
                    $importedCount++;
                }
            }

            $this->info($importedCount . ' produtos importados com sucesso!');
        } else {
            $this->error('Erro ao importar produtos!');
        }
    }

    /**
     * Importa um único produto da API externa com base no ID
     *
     * @param int $id
     * @return void
     */
    /**
 * Importa um único produto da API externa com base no ID
 *
 * @param int $id
 * @return void
 */
    /**
 * Importa um único produto da API externa com base no ID
 *
 * @param int $id
 * @return void
 */
    private function importSingleProduct($id)
    {
        $url = 'https://fakestoreapi.com/products/' . $id;

        $client = new Client();
        $response = $client->get($url);

        if ($response->getStatusCode() == 200) {
            $productData = json_decode($response->getBody(), true);

            if (!empty($productData['title'])) {
                // Verificar se o ID já existe no banco de dados
                $existingProduct = Product::find($id);
                if ($existingProduct) {
                    $this->info('ID já existe: ' . $id);
                    return;
                }

                // Desativar a funcionalidade de incremento automático do ID
                $product = new Product();
                $product->setIncrementing(false);

                // Salvar o produto com o ID fornecido
                $product->id = $id;
                $product->name = $productData['title'];
                $product->price = $productData['price'] ?? 0;
                $product->description = $productData['description'] ?? '';
                $product->category = $productData['category'] ?? '';
                $product->image_url = $productData['image_url'] ?? '';
                $product->save();

                $this->info('Produto importado com sucesso! ID: ' . $id);
            } else {
                $this->error('Título do produto ausente ou vazio. O produto não foi importado. ID: ' . $id);
            }
        } elseif ($response->getStatusCode() == 404) {
            $this->error('Produto não encontrado! ID: ' . $id);
        } else {
            $this->error('Erro ao importar o produto! ID: ' . $id);
        }
    }
    /**
     * Salva um produto no banco de dados
     *
     * @param array $productData
     * @return void
     */
    private function saveProduct($productData)
    {
        // Verificar se o ID e o nome do produto existem
        if (isset($productData['id']) && isset($productData['title'])) {
            $product = new Product();
            $product->name = $productData['title'];
            $product->price = $productData['price'] ?? 0; // Definir o preço como 0 se não estiver presente
            $product->description = $productData['description'] ?? ''; // Definir a descrição como vazia se não estiver presente
            $product->category = $productData['category'] ?? ''; // Definir a categoria como vazia se não estiver presente
            $product->image_url = $productData['image_url'] ?? ''; // Definir a URL da imagem como vazia se não estiver presente

            $product->save();

            return true;
        } else {
            $this->error('ID ou nome do produto ausente. O produto não foi importado.');
            return false;
        }
    }
}
