using System.Net.Http;
using Avalonia;
using Avalonia.Controls;
using Avalonia.Markup.Xaml;
using System;
using System.Threading.Tasks;
using Tmds.DBus.Protocol;
using Avalonia.Interactivity;

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
        TBlock.Text = result;
    }
    
    private void Button_Click_Enter(object sender, RoutedEventArgs e)
    {
        // Получение текста из TextBox
        searchFilter = SearchTB.Text;
        //Console.WriteLine(searchFilter);

        InitializeAsync();
    }
}