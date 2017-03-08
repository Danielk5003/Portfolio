using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Web;

namespace RecipeManager.Models
{
    public class RecipeManagerContext : DbContext
    {
        // You can add custom code to this file. Changes will not be overwritten.
        // 
        // If you want Entity Framework to drop and regenerate your database
        // automatically whenever you change your model schema, please use data migrations.
        // For more information refer to the documentation:
        // http://msdn.microsoft.com/en-us/data/jj591621.aspx
    
        public RecipeManagerContext() : base("name=RecipeManagerContext")
        {
        }

        public System.Data.Entity.DbSet<RecipeManager.Models.Recipe> Recipes { get; set; }

        public System.Data.Entity.DbSet<RecipeManager.Models.Chef> Chefs { get; set; }
    
    }
}
