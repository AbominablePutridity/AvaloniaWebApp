using System.Net.Http;
using Avalonia;
using Avalonia.Controls;
using Avalonia.Markup.Xaml;
using System;
using System.Threading.Tasks;
using Tmds.DBus.Protocol;

namespace Views;

public partial class MainPage : UserControl
{
    private HttpClient _httpClient;
    private GetProductsService _product;   
    string apiUrl = "products"; 

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
        string result = await _product.LoadDataAsync(apiUrl);
        TBlock.Text = result;
    }
    
}