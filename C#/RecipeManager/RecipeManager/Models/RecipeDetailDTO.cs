using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace RecipeManager.Models
{
    public class RecipeDetailDTO
    {
        public int Id { get; set; }
        public string Name { get; set; }
        public int Serves { get; set; }
        public string Time { get; set; }
        public string ChefName { get; set; }
        public string Ingredient { get; set; }
        public string Instruction { get; set; }

    }
}