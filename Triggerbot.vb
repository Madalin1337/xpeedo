'
' IT'S JUST A SIMPLE TRIGGERBOT CODED IN VB.NET
' MOST OF ALL COMMENTS ARE IN ROMANIAN, JUST IGNORE IT
'

Public Class Form1

    '=====================================================================================================================================
    '|       ADDRESS       |       DEFAULT VALUE AS HEXADECIMAL BYTE ARRAY        |        CHANGED VALUE AS HEXADECIMAL BYTE ARRAY       |
    '|#####################|######################################################|######################################################|
    '| samp.dll + 99250    | E9                                                   | C3                                                   |
    '| samp.dll + 286923   | 0F 85 8E F4 07 00 60 C7                              | B8 45 00 00 00 C2 1C 00                              |
    '| samp.dll + 298116   | 55 68 0D EF 04 F5 9C C7                              | B8 45 00 00 00 C2 1C 00                              |
    '| samp.dll + 2B9EE4   | 83 3D 30 A1 62 04 05 60 9C 8D 64 24                  | FF 05 00 41 57 56 A1 00 41 57 56 C3                  | -> NOT WORKING
    '=====================================================================================================================================
    '|       ADDRESS       |           DEFAULT VALUE AS DECIMAL 4 BYTE            |            CHANGED VALUE AS DECIMAL 4 BYTE           |
    '|#####################|######################################################|######################################################|
    '| samp.dll + 99250    | 507680745                                            | 507680707                                            |
    '| samp.dll + 286923   | 4102980879                                           | 17848                                                |
    '| samp.dll + 2B9EE4   | 4010633301                                           | 17848                                                |
    '| samp.dll + 298116   | 2704293251                                           | 1090520575                                           | -> NOT WORKING
    '=====================================================================================================================================

    Dim BaseAddress As Integer
    Dim proc As String = "gta_sa"

    'PENTRU DEBUG MODE:

    Dim disabled As String
    Dim firstcond
    Dim secondcond
    Dim renderped = "0"
    Dim slotweapon = "0"
    Dim checkingcar = "0"
    Dim shotstatus = "0"
    Dim pped = "0"

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

    Public Function disableAntiCheat()
        Try
            BaseAddress = GetModuleBaseAddress(proc, "samp.dll")
            firstcond = ReadLong(proc, BaseAddress + "&H99250", nsize:=4)
            secondcond = ReadLong(proc, BaseAddress + "&H286923", nsize:=4)
            If firstcond <> 507680707 Or secondcond <> 17848 Then
                WriteLong(proc, BaseAddress + "&H99250", Value:=507680707, nsize:=4)
                Sleep(100)
                WriteLong(proc, BaseAddress + "&H286923", Value:=17848, nsize:=4)
                disabled = "Yes"
            Else
                disabled = "Already Disabled"
            End If
        Catch ex As Exception

        End Try
    End Function

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        End
    End Sub

    Private Sub Timer1_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Timer1.Tick
        Try
            If disabled <> "Already Disabled or Not Disabled" Then
                disableAntiCheat()
            End If
        Catch ex As Exception
        End Try


        '
        ' DISABLE PED RENDER
        ' OFF = 1465445507
        ' ON = 1469092035
        '

        Try
            Dim pedrender = ReadLong(proc, "&H60BA80", nsize:=4)
            If CheckBox1.Checked = True Then
                If pedrender <> 1469092035 Then
                    WriteLong(proc, "&H60BA80", Value:=1469092035, nsize:=4)
                End If
            Else
                If pedrender <> 1465445507 Then
                    WriteLong(proc, "&H60BA80", Value:=1465445507, nsize:=4)
                End If
            End If
            renderped = pedrender.ToString
        Catch Ex As Exception
        End Try

        If CheckBox3.Checked = True Then
            Label1.Text = "Debug Mode:" + vbNewLine + _
                "Disabled: " + disabled.ToString + vbNewLine + _
                "First Address: " + firstcond.ToString + vbNewLine + _
                "Second Address: " + secondcond.ToString + vbNewLine + _
                "Ped Render: " + renderped + vbNewLine + _
                "Weapon Slot: " + slotweapon + vbNewLine + _
                "Checkcar: " + checkingcar + vbNewLine + _
                "Shoot: " + shotstatus + vbNewLine + _
                "Target: " + pped
        Else
            Label1.Text = "Debug Mode:"
        End If

        ' TRIGGERBOT
        ' URMATOARELE CONDITII:
        '
        ' SA FIE TINTA PUSA PE CINEVA, ADICA SA EXISTE TRIUNGHIUL VERDE
        ' SA DETINA O ARMA CORECT CORESPUNZATOARE
        ' SA NU FIE IN MASINA
        ' SI CAM ATAT.

        ' ALLOWED SLOTS:
        '
        ' ARMELE DE AICI SUNT PUSE LA GENERAL;
        ' 6236162 (2 as Deagle)
        ' 6236163 (3 as Shotgun)
        ' 6236164 (4 as MP5)
        ' 6236165 (5 as M4)
        ' 6236166 (6 as Rifle)
        ' 6236167 (7 as Minigun)
        ' 
        If CheckBox2.Checked = True Then
            Try
                Dim target = ReadDMALong(proc, "&HB6F5F0", Offsets:={&H79C}, Level:=1, nsize:=4)
                Dim slot = ReadDMALong(proc, "&HB6F5F0", Offsets:={&H718}, Level:=1, nsize:=4)
                Dim checkcar = ReadLong(proc, "&HBA18FC", nsize:=4)
                Dim BaseInput = GetModuleBaseAddress(proc, "DINPUT8.dll")
                Dim input = ReadLong(proc, BaseInput + "&H2FE8C", nsize:=4)

                If target > 0 Then
                    If _
                        slot = 6236162 Or _
                        slot = 6236163 Or _
                        slot = 6236164 Or _
                        slot = 6236165 Or _
                        slot = 6236166 Or _
                        slot = 6236167 Then
                        If checkcar = 0 Then
                            '
                            ' ACUM FOLOSIM DINPUT8.DLL
                            ' AVEM URMATOARELE VALORI:
                            ' 0 = Nimic
                            ' 128 = Doar Click Stanga
                            ' 32768 = Doar Click Dreapta
                            ' 32896 = Click stanga + Click dreapta

                            WriteLong(proc, BaseInput + "&H2FE8C", Value:=32896, nsize:=4)
                            Sleep(10)
                            WriteLong(proc, BaseInput + "&H2FE8C", Value:=32768, nsize:=4)
                            Sleep(1)
                            WriteDMALong(proc, "&HB6F5F0", Offsets:={&H79C}, Value:=0, Level:=1, nsize:=4)
                        End If
                    End If
                End If

                pped = target.ToString
                slotweapon = slot.ToString
                checkcar = checkingcar.ToString
                shotstatus = input.ToString

            Catch ex As Exception

            End Try
        End If
    End Sub

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        Timer1.Interval = 1
        Timer1.Start()
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        MsgBox("Goodule, vezi sa nu iei sursa codului si sa zici ca e facut de tine, ok?" + vbNewLine + "Apropo, e free.", MsgBoxStyle.OkOnly, "About")
    End Sub
End Class

'RECAPITULARE:
'DISABLE ANTICHEAT (ALA DE LA SAMP NU DE LA SERVER), ACEASTA CHESTIE PREVINE BLOCAREA JOCULUI
'SI RESTU, CE MAI SCRIE MAI SUS.
