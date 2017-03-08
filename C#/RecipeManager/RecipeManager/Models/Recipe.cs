using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Web;

namespace RecipeManager.Models
{
    public class Recipe
    {
        public int Id { get; set; }
        [Required]
        public string Name { get; set; }
        public int Serves { get; set; }
        public string Time { get; set; }
        public string Ingredient { get; set; }
        public string Instruction { get; set; }

        //Foreign Key
        public int ChefId { get; set; }
        //Navigation Property
        public Chef Chef { get; set; }
    }
}