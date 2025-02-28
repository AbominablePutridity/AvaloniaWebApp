using Avalonia.Controls;
using Views;
using Views.Menu;

namespace AvaloniaApp1;

public partial class MainWindow : Window
{
    public MainWindow()
    {
        InitializeComponent();
        MainFrame.Content = new MainPage();
        MenuFrame.Content = new MenuPage();
    }
}