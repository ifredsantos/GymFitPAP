using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace gymfit_app
{
	public static class config
	{
		public static string bd_gymfit;
		public static string bd_psw;
		public static cl_utilizador utilizador;
		public static string conn_string = "Persist Security Info=False;" +
            "server=localhost;" +
            "port=3306;" +
            "database=ginasio;" +
            "uid=root;" +
            "pwd=3";
		/*public static string conn_string = "Persist Security Info=False;server=localhost;" +
			"port=3306;database=ginasio;uid=root;pwd=";*/

		public static string dia_pagamento = "10";

		public static string getMD5Hash(string input)
		{
			System.Security.Cryptography.MD5 md5 = System.Security.Cryptography.MD5.Create();
			byte[] inputBytes = System.Text.Encoding.ASCII.GetBytes(input);
			byte[] hash = md5.ComputeHash(inputBytes);
			System.Text.StringBuilder sb = new System.Text.StringBuilder();
			for (int i = 0; i<hash.Length; i++)
			{
				sb.Append(hash[i].ToString("X2"));
			}
			return sb.ToString();
		}


	}
}
