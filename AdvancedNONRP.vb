'
' CHEAT CONCEPUT SPECIAL PENTRU CEI CARE VOR SA SE PLIMBE CU MASINILE DE FACTIUNE, ETC.
' PUTETI LUA MINIM KICK PENTRU DESYNC (NU DESYNC LA PROPRIU), MAXIM BAN.
'
Public Class Form1

    '/==========================|==============================================================================\
    '|        DESCRIPTION       |      ADDRESS     |             NOP             |            DEFAULT          |
    '|==========================|==================|=============================|=============================|
    '| TogglePlayerControllable | samp.dll + 168E0 | [754094275] / 2x[C3 90]     | [754076137] / 2x[E9 49]     |
    '| ClearAnimation           | samp.dll + 14C70 | [589271235] / 2x[C3 90]     | [589271273] / 2x[E9 90]     |
    '| SetPlayerPos             | samp.dll + 15970 | [767332547] / 2x[C3 90]     | [767299817] / 2x[E9 10]     |
    '| SetEngineState           | samp.dll + B2510 | [654312642] / 3x[C2 04 00]  | [669813589] / 3x[55 8B EC]  |
    '| RemovePlayerFromVehicle  | samp.dll + B2510 | [661819587] / 2x[C3 90]     | [661837801] / 2x[E9 D7]     |
    '| SetPlayerAnimation       | samp.dll + 16FA0 | [2213318851] / 2x[C3 90]    | [2213317461] / 2x[55 8B]    |
    '\=========================================================================================================/

    Dim BaseAddress As Integer
    Dim proc As String = "gta_sa"

    Declare Sub Sleep Lib "kernel32" (ByVal milliseconds As Integer)


    Public Function GetModuleBaseAddress(ByVal ProcessName As String, ByVal ModuleName As String) As Integer
        Try
            For Each PM As ProcessModule In Process.GetProcessesByName(ProcessName)(0).Modules
                If ModuleName = PM.ModuleName Then
                    BaseAddress = PM.BaseAddress
                End If
            Next
        Catch ex As Exception

        End Try
        Return BaseAddress

    End Function

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        If Button1.Text = "Baga NOP in Bugged" Then
            Button1.Text = "Scoate NOP din Bugged"
            Timer1.Start()
        Else
            Button1.Text = "Baga NOP in Bugged"
            Timer1.Stop()
            Try
                Dim sampADDR = GetModuleBaseAddress(proc, "samp.dll")
                WriteLong(proc, sampADDR + "&H168E0", Value:=754076137, nsize:=4)
                WriteLong(proc, sampADDR + "&H14C70", Value:=589271273, nsize:=4)
                WriteLong(proc, sampADDR + "&H15970", Value:=767299817, nsize:=4)
                WriteLong(proc, sampADDR + "&HB2510", Value:=669813589, nsize:=4)
                WriteLong(proc, sampADDR + "&H146E0", Value:=661837801, nsize:=4)
                WriteLong(proc, sampADDR + "&H16FA0", Value:=2213317461, nsize:=4)
            Catch ex As Exception

            End Try
        End If
    End Sub

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        Timer1.Interval = 1
    End Sub

    Private Sub Timer1_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Timer1.Tick
        Try
            Dim sampADDR = GetModuleBaseAddress(proc, "samp.dll")

            Dim TogglePlayerControllable = ReadLong(proc, sampADDR + "&H168E0", nsize:=4)
            Dim ClearAnimation = ReadLong(proc, sampADDR + "&H14C70", nsize:=4)
            Dim SetPlayerPos = ReadLong(proc, sampADDR + "&H15970", nsize:=4)
            Dim SetEngineState = ReadLong(proc, sampADDR + "&HB2510", nsize:=4)
            Dim RemovePlayerFromVehicle = ReadLong(proc, sampADDR + "&HB2510", nsize:=4)
            Dim SetPlayerAnimation = ReadLong(proc, sampADDR + "&H16FA0", nsize:=4)
            If TogglePlayerControllable <> 754094275 And ClearAnimation <> 589271235 And SetPlayerPos <> 767332547 And SetEngineState <> 1358955714 And RemovePlayerFromVehicle <> 661819587 And SetPlayerAnimation <> 2213318851 Then
                WriteLong(proc, sampADDR + "&H168E0", Value:=754094275, nsize:=4)
                WriteLong(proc, sampADDR + "&H14C70", Value:=589271235, nsize:=4)
                WriteLong(proc, sampADDR + "&H15970", Value:=767332547, nsize:=4)
                WriteLong(proc, sampADDR + "&HB2510", Value:=654312642, nsize:=4)
                WriteLong(proc, sampADDR + "&H146E0", Value:=661819587, nsize:=4)
                WriteLong(proc, sampADDR + "&H16FA0", Value:=2213318851, nsize:=4)
            End If
        Catch ex As Exception

        End Try
    End Sub
End Class
