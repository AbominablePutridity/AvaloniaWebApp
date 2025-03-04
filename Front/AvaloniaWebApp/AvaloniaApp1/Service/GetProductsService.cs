using System;
using System.Net.Http;
using System.Threading.Tasks;

class GetProductsService
{
    const string API_HOST = "http://localhost:8000/api/";

    private readonly HttpClient _httpClient;

    // Конструктор, принимающий HttpClient
    public GetProductsService(HttpClient httpClient)
    {
        _httpClient = httpClient;
    }

    // Асинхронный метод для получения JSON
    public async Task<string> GetJsonAsync(string path)
    {
        try
        {
            // Выполняем GET-запрос к API
            HttpResponseMessage response = await _httpClient.GetAsync(API_HOST + path);

            // Проверяем, успешен ли запрос
            if (response.IsSuccessStatusCode)
            {
                // Читаем ответ как строку (JSON)
                return await response.Content.ReadAsStringAsync();
            }
            else
            {
                // Если запрос неуспешен, выбрасываем исключение с кодом статуса
                throw new HttpRequestException($"Ошибка: {response.StatusCode}");
            }
        }
        catch (Exception ex)
        {
            // Ловим и обрабатываем исключения
            throw new Exception($"Исключение при запросе к API: {ex.Message}");
        }
    }

    public async Task<string> LoadDataAsync(string apiUrl)
    {
        string response = null;

        try
        {
            // Вызываем метод для получения JSON
            string jsonResponse = await this.GetJsonAsync(apiUrl);

            // Выводим JSON в консоль
            //Console.WriteLine(jsonResponse);
            response = jsonResponse;
        }
        catch (Exception ex)
        {
            response = $"Ошибка: {ex.Message}";
        }

        Console.WriteLine(response);
        return response;
    }
}