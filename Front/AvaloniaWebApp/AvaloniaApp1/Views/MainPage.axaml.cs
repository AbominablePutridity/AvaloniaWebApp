using System.Net.Http;
using Avalonia;
using Avalonia.Controls;
using Avalonia.Markup.Xaml;
using System;
using System.Threading.Tasks;
using Tmds.DBus.Protocol;
using Avalonia.Interactivity;
using System.Text.Json;

namespace Views;

public partial class MainPage : UserControl
{
    private HttpClient _httpClient;
    private GetProductsService _product;  
    string searchFilter = "";

    string apiUrl = "products?page=1&amountOfPages=6"; 

    public MainPage()
    {
        _httpClient = new HttpClient();
        _product = new GetProductsService(_httpClient);

        InitializeComponent();

        // Запускаем асинхронную загрузку данных
        InitializeAsync();
    }

    private async void InitializeAsync()
    {
        if ((searchFilter != "") || (searchFilter != null)) {
            apiUrl = apiUrl + "?page=1&amountOfPages=6&author=" + searchFilter;
        }

        string result = await _product.LoadDataAsync(apiUrl);

        Console.WriteLine(result);

        // Парсинг JSON строки в массив объектов
        Product[] products = JsonSerializer.Deserialize<Product[]>(result);

        // foreach (string item in products)
        // {
        //     Console.WriteLine(item);
        // }

        // перебор массива с обьектами продуктов и запись каждого продукта в отдельный блок
        for (int i = 0; i < products.Length; i++) {
            switch (i) {
                case 0:
                    TBlockName.Text = products[0].name;
                    TBlockDescription.Text = products[0].description;
                    TBlockSize.Text = products[0].size;
                    break;
                case 1:
                    //TODO
                    break;
                case 2:
                    //TODO
                    break;
                case 3:
                    //TODO
                    break;
                case 4:
                    //TODO
                    break;
                case 5:
                    //TODO
                    break;
            }
        }

        Console.WriteLine(products[0].name);
    }
    
    private void Button_Click_Enter(object sender, RoutedEventArgs e)
    {
        // Получение текста из TextBox
        searchFilter = SearchTB.Text;
        //Console.WriteLine(searchFilter);

        InitializeAsync();
    }
}