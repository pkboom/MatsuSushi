Vue.component('matsu-menux', require('./components/matsu-menux.vue'));
Vue.component('matsu-menu-category', require('./components/matsu-menu-category.vue'));
Vue.component('add-to-cart', require('./components/add-to-cart.vue'));

if (document.getElementById('app-menu')) {
	const appMenu = new Vue({
		el: '#app-menu',

		data: 
		{
			oneWeek: 7,
			subCategoryCount: 15,
			ordered: false,
			orderItemTitle: '',
			orderItemPrice: '',
			orderItemCount: 0,
			orderItems: [],
<<<<<<< 206b94ce10319827f6348f99a360e53479e9642f
			category: [],
=======
			subCategoryInfo: [
			{
				name: "Noodle and Maki Special(11: 30 AM to 4 PM)",
				data: [
				{
					title: "Ramen or Udon + Maki",
					descript: "California 6pcs/ yam 6pcs/ avocado 6pcs/ dynamite 5pcs/ spicy salmon 4pcs/ spicy tuna 4pcs",
					price: "12.95"
				},
				],
			},
			{
				name: "Appetizer Special",
				data: [
				{
					title: "Butterfly Shrimp",
					descript: "Breaded shrimp and crab meat",
					price: "7.95"
				},
				{
					title: "Shrimp Teriyaki",
					descript: "6 pcs tiger shrimp",
					price: "8.95"
				},
				{
					title: "Takoyaki",
					descript: "8pcs Tako with homemade sauce",
					price: "5.95"
				},
				],
			},
			{
				name: "Dinner Special",
				data: [
				{
					title: "Spicy Rice Cake (떡볶이)",
					descript: "homemade hot sauce with vegetable",
					price: "12.95"
				},
				{
					title: "Mild Rice Cake (궁중 떡볶이)",
					descript: "based soya sauce with beef and vegetable",
					price: "13.95"
				},
				{
					title: "Nabe Udon",
					descript: "mussels, shrimp, crabmeat, fishcake, vegetable and egg",
					price: "14.95"
				},
				{
					title: "Budae Jigae (부대찌개)",
					descript: "kimchi, ham, sausage, tofu, ramen, vegetable (for 2 people)",
					price: "24.95"
				},
				{
					title: "Stir-fried Spicy Pork (제육볶음)",
					descript: "",
					price: "16.95"
				},
				{
					title: "Spicy Chicken",
					descript: "stir-fried chicken and vegetable with homemade spicy sauce",
					price: "17.95"
				},
				],
			},
			{
				name: "Dessert Special",
				data: [
				{
					title: "Deep-fried Ice-cream",
					descript: "Green tea/Vanilla/Mango",
					price: "6.95"
				},
				],
			},
			{
				name: "SOUP & SALAD",
				data: [
				{
					title: "MISO SOUP",
					descript: "soybean paste soup with green onion",
					price: "1.95"
				},
				{
					title: "WONTON SOUP",
					descript: "clear soup with dumpling",
					price: "3.95"
				},
				{
					title: "SEAFOOD SOUP",
					descript: "Clean Japanese style fish broth with seafood and green onion",
					price: "4.95"
				},
				{
					title: "HIYASHI WAKAME SALAD",
					descript: "Fresh seaweed salad",
					price: "5.95"
				},
				{
					title: "GREEN SALAD",
					descript: "Crispy garden greens with our special homemade dressing",
					price: "4.95"
				},
				{
					title: "SUNOMONO SALAD",
					descript: "Fresh sweed salad with cucumber, shrimp, crab and light vinaigrette",
					price: "7.95"
				},
				{
					title: "SPICY GARDEN SALAD",
					descript: "Crispy garden greens with spicy homemade dressing",
					price: "6.95"
				},
				{
					title: "SPINACH SALAD",
					descript: "marinated boiled spinach with a light vinaigrette",
					price: "4.95"
				},
				{
					title: "AVOCADO SALAD",
					descript: "",
					price: "6.95"
				},
				{
					title: "GREEN SALAD AND MISO SOUP",
					descript: "",
					price: "4.95"
				},
				{
					title: "STEAM RICE",
					descript: "",
					price: "1.95"
				},
				],
			},
			{
				name: "APPETIZER",
				data: [
				{
					title: "VEGETABLES TEMPURA",
					descript: "Assorted vegetables tempura",
					price: "6.95"
				},
				{
					title: "SHRIMP & VEGETABLE TEMPURA(S)",
					descript: "",
					price: "7.95"
				},
				{
					title: "SHRIMP & VEGETABLE TEMPURA(L)",
					descript: "",
					price: "16.95"
				},
				{
					title: "SHRIMP TEMPURA (4pcs)",
					descript: "",
					price: "7.95"
				},
				{
					title: "SQUID TEMPURA",
					descript: "",
					price: "9.95"
				},
				{
					title: "YAM TEMPURA",
					descript: "",
					price: "7.95"
				},
				{
					title: "GYOZA(5pcs)",
					descript: "BEEF",
					price: " 5.95"
				},
				{
					title: "GYOZA(10pcs)",
					descript: "BEEF",
					price: "9.95"
				},
				{
					title: "EDAMAME",
					descript: "",
					price: "4.95"
				},
				{
					title: "EGG PLANT TERIYAKI (6pcs)",
					descript: "",
					price: "4.95"
				},
				{
					title: "SUSHI PIZZA",
					descript: "",
					price: "9.95"
				},
				{
					title: "SASHIMI (9pcs)",
					descript: "salmon, tuna, snapper",
					price: "10.95"
				},
				{
					title: "SAKE (SALMOM) SASHIMI (6pcs)",
					descript: "",
					price: "9.95"
				},
				{
					title: "MAGURO SASHIMI (6pcs)",
					descript: "",
					price: "11.95"
				},
				{
					title: "HAMACHI SASHIMI (6pcs)",
					descript: "",
					price: "13.95"
				},
				{
					title: "SUSHI (6pcs)",
					descript: "Sushi rice on top assorted raw fish",
					price: "9.95"
				},
				{
					title: "AGEDASHI TOFU (8pcs)",
					descript: "Deep fried tofu with teriyaki sauce or sweet and Chile",
					price: "5.95"
				},
				{
					title: "SOFT SHELL CRAB",
					descript: "Deep fried Soft shell tempura",
					price: "11.95"
				},
				{
					title: "HARUMAKI (5pcs)",
					descript: "(SPRING ROLL)-vegetables",
					price: "5.95"
				},
				{
					title: "CHICKEN KARA-AGE",
					descript: "eep fried chicken leg meat bite with homemade banana sauce",
					price: "10.75"
				},
				{
					title: "YAKIDORI (2pcs)",
					descript: "Grilled chicken leg meat and vegetable with teriyaki sauce",
					price: "9.50"
				},
				{
					title: "SEAFOOD KOREAN PANCAKE",
					descript: "vegetable pancake with fresh seafood",
					price: "22.95"
				},
				],
			},
			{
				name: "RICE FREE MAKI (SOYBEAN PAPER) (8PCS)",
				data: [
				{
					title: "DAISY",
					price: "12.95",
					descript: "Fried shrimp, avocado, lettuce, pickled radish, topped with salmon and spicy mayo"
				},
				{
					title: "SUNFLOWER",
					price: "12.95",
					descript: ""
				},					
				{
					title: "TULIP",
					price: "13.95",
					descript: "Soft shell crab, crab meat, avocado, mayo, topped with unagi sauce"
				},					
				{
					title: "VIOLET",
					price: "11.95",
					descript: "Pickled radish, pickled mushroom, cucumber, lettuce, topped with avocado"
				},
				{
					title: "SPRING MAKI",
					price: "13.95",
					descript: "avovcado, fried shrimp, spicy salmon or tuna, unagi and soy paper"
				},
				],
			},
			{
				name: "FUSION MAKI (5PCS/10PCS)",
				data: [
				{
					title: "DYNAMITE MAKI(5pcs)",
					price: "6.95",
					descript: "Shrimp tempura, cucumber, crab and avocado"
				},
				{
					title: "DYNAMITE MAKI(10pcs)",
					price: "10.95",
					descript: "Shrimp tempura, cucumber, crab and avocado"
				},
				{
					title: "FUTO MAKI(5pcs)",
					price: "6.95",
					descript: "cucumber, crab meat, pickle"
				},
				{
					title: "FUTO MAKI(10pcs)",
					price: "10.95",
					descript: "cucumber, crab meat, pickle"
				},
				{
					title: "SPIDER MAKI(5pcs)",
					price: "7.95",
					descript: "Deep fried soft shell crab, cucumber, avocado, and crab meat"
				},
				{
					title: "SPIDER MAKI(10pcs)",
					price: "12.95",
					descript: "Deep fried soft shell crab, cucumber, avocado, and crab meat"
				},
				{
					title: "PHILADELPHIA MAKI(5pcs)",
					price: "6.95",
					descript: "smoked salmon, cream cheese, avocado, cucumber"
				},
				{
					title: "PHILADELPHIA MAKI(10pcs)",
					price: "11.95",
					descript: "smoked salmon, cream cheese, avocado, cucumber"
				},
				{
					title: "CRISPY PHILADELPHIA MAKI(5pcs)",
					price: "7.95",
					descript: "philadelpia tempura maki"
				},
				{
					title: "CRISPY PHILADELPHIA MAKI(10pcs)",
					price: "13.95",
					descript: "philadelpia tempura maki"
				},
				{
					title: "CHICKEN TERIYAKI MAKI(5pcs)",
					price: "5.95",
					descript: "grilled chicken breast, cucumber, teriyaki sauce"
				},
				{
					title: "CHICKEN TERIYAKI MAKI(10pcs)",
					price: "9.95",
					descript: "grilled chicken breast, cucumber, teriyaki sauce"
				},
				{
					title: "BULGOGI MAKI(5pcs)",
					price: "5.95",
					descript: "grilled bulgogi, cucumber"
				},
				{
					title: "BULGOGI MAKI(10pcs)",
					price: "9.95",
					descript: "grilled bulgogi, cucumber"
				},
				{
					title: "CALIFORNIA(5pcs)",
					price: "5.95",
					descript: "avocado, crab meat, cucumber"
				},
				{
					title: "CALIFORNIA(10pcs)",
					price: "10.95",
					descript: "avocado, crab meat, cucumber"
				},
				{
					title: "CRISPY CALIFORNIA(5pcs)",
					price: "6.95",
					descript: "California maki tempura"
				},
				{
					title: "CRISPY CALIFORNIA(10pcs)",
					price: "11.95",
					descript: "California maki tempura"
				},
				{
					title: "GIANT MAKI(5pcs)",
					price: "5.95",
					descript: "salmon, tuna, crab meat, cucumber"
				},
				{
					title: "GIANT MAKI(10pcs)",
					price: "9.95",
					descript: "salmon, tuna, crab meat, cucumber"
				},
				{
					title: "PINK LADY MAKI(5pcs)",
					price: "6.95",
					descript: "deep fried shrimp, cucumber, avocado, in pink soybean paper"
				},
				{
					title: "PINK LADY MAKI(10pcs)",
					price: "11.95",
					descript: "deep fried shrimp, cucumber, avocado, in pink soybean paper"
				},
				{
					title: "MOON MAKI(5pcs)",
					price: "7.95",
					descript: "Deep fried shrimp, unagi, cucumber, avocado, soybean paper"
				},					
				{
					title: "MOON MAKI(10pcs)",
					price: "14.95",
					descript: "Deep fried shrimp, unagi, cucumber, avocado, soybean paper"
				},					
				{
					title: "HUNTER MAKI(5pcs)",
					price: "6.95",
					descript: "Spicy salmon or tuna, avocado, soybean pape"
				},
				{
					title: "HUNTER MAKI(10pcs)",
					price: "10.95",
					descript: "Spicy salmon or tuna, avocado, soybean pape"
				},
				{
					title: "ROSE MAKI(5pcs)",
					price: "6.95",
					descript: "Pan-fried shitake mushrooms, crab, avocado, soybean pape"
				},				
				{
					title: "ROSE MAKI(10pcs)",
					price: "10.95",
					descript: "Pan-fried shitake mushrooms, crab, avocado, soybean pape"
				},				
				{
					title: "BOSTON MAKI(5pcs)",
					price: "8.95",
					descript: "Calamari tempura, cucumber, lettuce, avocad"
				},
				{
					title: "BOSTON MAKI(10pcs)",
					price: "14.95",
					descript: "Calamari tempura, cucumber, lettuce, avocad"
				},
				{
					title: "OTTAWA MAKI(5pcs)",
					price: "7.95",
					descript: "Deep fried tuna, avocado, cucumber and cream cheese"
				},	
				{
					title: "OTTAWA MAKI(10pcs)",
					price: "13.95",
					descript: "Deep fried tuna, avocado, cucumber and cream cheese"
				},	
				{
					title: "LOBSTER MAKI",
					price: "18.95",
					descript: "deep fried lobster, cucumber"
				},
				{
					title: "WHISHER MAKI",
					price: "11.95",
					descript: "Bulgogi, avocado, cucumber, enoki mushroom, cheese and deep fried"
				},
				{
					title: "BANFF MAKI",
					price: "10.95",
					descript: "Bulgogi, avocado, cucumber, enoki mushroom, cheese and deep fried"
				},
				{
					title: "VANCOUVER MAKI",
					price: "9.95",
					descript: "Bulgogi, enoki mushroom, cucumber, avocado"
				},
				{
					title: "OLYMPIC MAKI",
					price: "12.95",
					descript: "Beef, cucumber, cream cheese, enoki mushroom, fried in tempura"
				},
				{
					title: "GREEN DRAGON ROLL",
					price: "12.95",
					descript: "dynamite roll topped with fresh slices of avocado"
				},
				{
					title: "RED DRAGON ROLL",
					price: "13.95",
					descript: "dynamite roll with tuna sashimi"
				},
				{
					title: "BLACK DRAGON ROLL",
					price: "14.95",
					descript: "dynamite roll topped with BBQ eel"
				},
				{
					title: "WHITE DRAGON ROLL",
					price: "13.95",
					descript: "dynamite roll topped white tuna and unagi sauce"
				},
				{
					title: "GOLDEN DRAGON ROLL",
					price: "12.95",
					descript: "dynamite roll topped salmon"
				},
				{
					title: "SATTU DRAGON ROLL",
					price: "13.95",
					descript: "dynamite roll topped tuna and salmon"
				},
				{
					title: "DRAGON MAKI",
					price: "13.95",
					descript: "unagi maki topped with sliced avocado"
				},
				],
			},
			{
				name: "FUSION MEDIUM MAKI (6PCS)",
				data: [
				{
					title: "BLUE MOUNTAIN MAKI",
					price: "13.95",
					descript: "Unagi maki topped with spicy salmon, unagi sauce, mayo, and tempura powder"
				},
				{
					title: "CATERPILLAR MAKI",
					price: "9.95",
					descript: "California maki topped with unagi and avocado"
				},
				{
					title: "RAINBOW MAKI",
					price: "8.95",
					descript: "California maki topped with sashimi and avocado"
				},
				{
					title: "ALASKA MAKI",
					price: "8.95",
					descript: "California maki topped with smoked salmon"
				},
				{
					title: "SKYDOM MAKI",
					price: "8.95",
					descript: "Deep fried soft shell crab with cucumber"
				},
				{
					title: "SPIDER MAKI",
					price: "9.95",
					descript: "Deep fried soft shell crab with cucumber"
				},
				{
					title: "SPICY SALMON OR TUNA MAKI",
					price: "7.95",
					descript: ""
				},
				{
					title: "KAMIKAJE MAKI",
					price: "7.95",
					descript: "fresh tuna, tempura powder, green onion and spicy sauce"
				},
				{
					title: "PETERBOROUGH MAKI",
					price: "6.95",
					descript: "Tuna, salmon, green onion"
				},
				{
					title: "HAMACHI NEKI MAKI",
					price: "7.95",
					descript: "yellow tail and green onion"
				},
				{
					title: "UNAGI MAKI",
					price: "8.95",
					descript: "Grilled eel with cucumber"
				},
				{
					title: "SALMON SKIN MAKI",
					price: "6.95",
					descript: "Deep fried salmon skin"
				},
				{
					title: "CALIFORNIA MAKI",
					price: "4.95",
					descript: "crab meat, avocado, cucumber"
				},
				{
					title: "WEST COAST MAKI",
					price: "8.95",
					descript: "deep fried California maki topped with salmon"
				},
				{
					title: "PEARL",
					price: "7.95",
					descript: "Avocado and BBQ salmon with teriyaki sauce"
				},
				{
					title: "BILL MAKI",
					price: "11.95",
					descript: "Deep fried shrimp, crab, avocado, cream cheese, cucumber"
				},
				{
					title: "SALMON FAMILY MAKI",
					price: "13.95",
					descript: "Fried salmon skin, cucumber topped with salmon and raw"
				},
				{
					title: "SPICY WHITE TUNA MAKI",
					price: "8.95",
					descript: ""
				},
				{
					title: "ULTIMATE MAKI",
					price: "15.95",
					descript: "Soft shell crab, avocado and cucumber topped with shrimp, avocado, unagi, and crab"
				},
				{
					title: "ORANGE",
					price: "8.95",
					descript: "Salmon make topped with spicy salmon"
				},
				{
					title: "CRAB SALAD MAKI",
					price: "6.95",
					descript: "Crab meat, mayo and cucumber"
				},
				{
					title: "MBA MAKI",
					price: "9.95",
					descript: "Smoked salmon, cucumber, crab"
				},
				{
					title: "SPICY TUNA / SPICY SALMON",
					price: "7.95",
					descript: ""
				},
				{
					title: "TUNA / SALMON",
					price: "6.95",
					descript: ""
				},
				{
					title: "TAMAGO MAKI (EGG)",
					price: "4.95",
					descript: ""
				},
				{
					title: "EBI MAKI (SHRIMP)",
					price: "5.95",
					descript: ""
				},
				{
					title: "KANI MAKI (CRAB MEAT)",
					price: "4.95",
					descript: ""
				},
				],
			},
			{
				name: "VEGETABLE MAKI (6PCS)",
				data: [
				{
					title: "AVOCADO",
					price: "4.95",
					descript: ""
				},
				{
					title: "KAPPA (CUCUMBER)",
					price: "4.95",
					descript: ""
				},
				{
					title: "AVO-Q (AVOCADO, CUCUMBER)",
					price: "4.95",
					descript: ""
				},
				{
					title: "AVO-CREAM",
					price: "6.95",
					descript: "Avocado with cream cheese"
				},
				{
					title: "ASPARAGUS",
					price: "7.95",
					descript: ""
				},
				{
					title: "MIXED VEGETABLE MAKI",
					price: "5.95",
					descript: "Cucumber, pickled radish and pickled squash"
				},
				{
					title: "SQUASH MAKI / YAM MAKI",
					price: "4.95",
					descript: "Pickled squash"
				},
				{
					title: "SPINACH MAKI",
					price: "5.95",
					descript: ""
				},
				{
					title: "VICTORIA MAKI",
					price: "6.95",
					descript: "enoki mushroom, avocado, cucumber"
				},
				{
					title: "CRISPY MAKI",
					price: "5.95",
					descript: "Tempura powder mixed spicy mayo and rolled in rice"
				},
				],
			},
			{
				name: "HAND ROLL (1PC)",
				data: [
				{
					title: "CALIFORNIA",
					price: "3.95",
					descript: ""
				},
				{
					title: "TEKKA(TUNA)",
					price: "4.95",
					descript: ""
				},
				{
					title: "SAKE(SALMON)",
					price: "4.95",
					descript: ""
				},
				{
					title: "HAMACHI",
					price: "5.95",
					descript: ""
				},
				{
					title: "SKYDOM",
					price: "6.95",
					descript: ""
				},
				{
					title: "SALMON SKIN",
					price: "4.95",
					descript: ""
				},
				{
					title: "SPICY SALMON OR TUNA",
					price: "4.95",
					descript: ""
				},
				],
			},
			{
				name: "SPECIAL COMBINATION (SALAD AND MISO SOUP)",
				data: [
				{
					title: "PETERBOROUGH COMBO 18PCS",
					price: "16.95",
					descript: "California maki, salmon maki, skydom maki"
				},
				{
					title: "FUTO COMBO 16PCS",
					price: "18.95",
					descript: "Futo maki, California maki, Philadelphia maki"
				},
				{
					title: "KAWARTHA COMBO 18PCS",
					price: "20.95",
					descript: "Rainbow maki, caterpillar maki, spicy salmon or tuna maki"
				},
				{
					title: "MATSU COMBO 18PCS",
					price: "25.95",
					descript: "Dynamite maki, blue mountain maki, Alaska maki"
				},
				{
					title: "VEGETABLE COMBO",
					price: "14.95",
					descript: "Kappa maki, avocado maki, yam maki"
				},
				{
					title: "SALMON LOVER’S COMBO",
					price: "18.95",
					descript: "BBQ salmon with cream cheese maki, spicy salmon salad maki, salmon katsu maki"
				},
				{
					title: "KAYA COMBO",
					price: "16.95",
					descript: "ASPARAGUS MAKI, YAM MAKI, AVOCADO MAKI"
				},
				{
					title: "MATSU V.I.P COMBO",
					price: "27.95",
					descript: "BBQ salmon with cream cheese maki, crispy salmon maki, crispy red and white tuna maki"
				},
				{
					title: "SATTU-GREEN DREGON COMBO",
					price: "20.95",
					descript: ""
				},
				{
					title: "RED-GOLD DREGON COMBO",
					price: "20.95",
					descript: ""
				},
				{
					title: "GREEN-GOLD DREGON COMBO",
					price: "20.95",
					descript: ""
				},
				{
					title: "RED-GOLD-GREEN DREGON COMBO",
					price: "28.95",
					descript: ""
				},
				{
					title: "ATLANTIC MAKI 5PCS",
					price: "14.95",
					descript: "spicy tuna maki, and 5pcs spicy salmon maki (soybean paper)"
				},
				{
					title: "GARDEN MAKI 5pcs",
					price: "13.95",
					descript: "yam tempura, asparagus and 5pcs avo-q (soybean paper)"
				},
				{
					title: "SPRING SHRIMP 5pcs",
					price: "14.95",
					descript: "tempura shrimp, yam maki, and 5pcs dynamite maki (soybean paper)"
				},
				],
			},
			{
				name: "A LA CARTE (2PCS PER ORDER)",
				data: [
				{
					title: "SAKE (SALMON)",
					price: "5.95",
					descript: ""
				},
				{
					title: "TAKO (OCTOPUS)",
					price: "7.95",
					descript: ""
				},
				{
					title: "MAGURO (RED TUNA)",
					price: "6.95",
					descript: ""
				},
				{
					title: "HOTATEKAI (SCALLOP) 7.95",
					price: "7.95",
					descript: ""
				},
				{
					title: "UNAGI (EEL)",
					price: "7.95",
					descript: ""
				},
				{
					title: "TAMAGO (EGG)",
					price: "4.95",
					descript: ""
				},
				{
					title: "EBI (SHRIMP)",
					price: "5.95",
					descript: ""
				},
				{
					title: "HOKIKAI (CLAM)",
					price: "5.95",
					descript: ""
				},
				{
					title: "TAI (RED SNAPPER)",
					price: "5.25",
					descript: ""
				},
				{
					title: "SABA (MACKEREL)",
					price: "7.95",
					descript: ""
				},
				{
					title: "HIRAME (FLOUNDER)",
					price: "7.95",
					descript: ""
				},
				{
					title: "KANI (CRAB)",
					price: "4.95",
					descript: ""
				},
				{
					title: "HAMACHI (YELLOW TAIL)",
					price: "7.95",
					descript: ""
				},
				{
					title: "TOBIKO (FLYING FISH ROE)",
					price: "6.95",
					descript: ""
				},
				{
					title: "INARI (FRIED BEAN CURD) ",
					price: "5.95",
					descript: ""
				},
				{
					title: "MASAGO (SMELT FISH ROE)",
					price: "6.95",
					descript: ""
				},
				],
			},
			{
				name: "LUNCH BENTO BOX (UNTIL 4PM WITH SALAD AND SOUP)",
				data: [
				{
					title: "LUNCH A",
					price: "12.95",
					descript: "8pcs nigiri, 6pcs maki"
				},
				{
					title: "LUNCH B",
					price: "11.95",
					descript: "6pcs nigiri, 6pcs maki"
				},
				{
					title: "LUNCH C",
					price: "10.95",
					descript: "4pcs nigiri, 6pcs maki"
				},
				{
					title: "LUNCH D",
					price: "13.95",
					descript: "5pcs dynamite maki, 5pcs spider maki"
				},
				{
					title: "LUNCH E",
					price: "11.95",
					descript: "5pcs futo maki, 5pcs California maki"
				},
				{
					title: "LUNCH F",
					price: "13.95",
					descript: "6pcs rainbow maki, 6pcs caterpillar makI"
				},
				{
					title: "LUNCH G",
					price: "11.95",
					descript: "6pcs spicy salmon maki, 6pcs spicy tuna maki"
				},
				{
					title: "LUNCH H",
					price: "12.95",
					descript: "6pcs skydom maki, 6pcs salmon skin maki"
				},
				{
					title: "LUNCH I",
					price: "9.95",
					descript: "12pcs California maki"
				},
				{
					title: "LUNCH J VEGETABLES MAKI",
					price: "9.95",
					descript: "12pcs avo-q, yam maki"
				},
				{
					title: "CHIRASHI",
					price: "13.95",
					descript: "Assorted sashimi on sushi rice"
				},
				{
					title: "LB-1 CHICKEN OR SALMON TERIYAKI",
					price: "11.95",
					descript: "with 6pcs California maki"
				},
				{
					title: "LB-2 BEEF TERIYAKI OR BULGOGI OR SPICY BULGOGI",
					price: "13.95",
					descript: "with 6pcs California maki"
				},
				{
					title: "LB-3 PORK OR CHICKEN KATSU",
					price: "13.95",
					descript: "deep fried with panko with 6pcs California maki"
				},
				{
					title: "LB-4 TEMPURA + CHICKEN OR SALMON TERIYAKI COMBO",
					price: "13.95",
					descript: ""
				},
				{
					title: "LB-5 TEMPURA + BEEF TERIYAKI OR BULGOGI COMBO",
					price: "13.95",
					descript: ""
				},
				{
					title: "LB-6 TEMPURA + SUSHI (3PCS) COMBO",
					price: "13.95",
					descript: ""
				},
				{
					title: "LB-7 SUSHI and SASHIMI",
					price: "14.95",
					descript: ""
				},
				],
			},
			{
				name: "NOODLE DISHES",
				data: [
				{
					title: "SPICY SEAFOOD UDON",
					price: "14.95",
					descript: "seafood and vegetables in a spicy soup with noodles"
				},
				{
					title: "TEMPURA UDON",
					price: "14.95",
					descript: "Assorted tempura served with noodles"
				},
				{
					title: "NABE",
					price: "13.95",
					descript: "VEGETALBLE, CHICKEN, BEEF"
				},
				{
					title: "YAKI",
					price: "15.95",
					descript: "VEGETABLE, CHICKEN, BEEF, SEAFOOD"
				},
				{
					title: "SPICY VEGETABLE RAMEN",
					price: "10.95",
					descript: ""
				},
				{
					title: "SPICY CHICKEN RAMEN OR SEAFOOD RAMEN",
					price: "13.95",
					descript: ""
				},
				{
					title: "JAP CHAE",
					price: "13.95",
					descript: "Glass noodles served with vegetables"
				},
				{
					title: "MORI SOBA",
					price: "13.95",
					descript: "Cold soba noodles served with homemade soba dipping sauce"
				},
				],
			},
			{
				name: "DINNER KOREAN & JAPANESE MAIN DISH",
				data: [
				{
					title: "CHICKEN OR TOFU TERIYAKI",
					price: "14.95",
					descript: ""
				},
				{
					title: "SALMON TERIYAKI",
					price: "16.95",
					descript: ""
				},
				{
					title: "BEEF TERIYAKI",
					price: "18.95",
					descript: ""
				},
				{
					title: "SHRIMP AND VEGETABLE TEMPURA",
					price: "16.95",
					descript: ""
				},
				{
					title: "CHICKEN OR PORK KATSU",
					price: "18.95",
					descript: "deep fried with panko with homemade katsu sauce"
				},
				{
					title: "CHICKEN & SHRIMP KARA-AGE",
					price: "19.95",
					descript: "Panko Chicken strips, shrimp katsu and vegetable"
				},
				{
					title: "BULGOGI OR SPICY BULGOGI",
					price: "17.95",
					descript: ""
				},
				{
					title: "BI BIM BAP",
					price: "11.95",
					descript: "Mix vegetables, egg, rice and beef with homemade spicy sauce"
				},
				{
					title: "SASHIMI BI BIM BAP",
					price: "15.95",
					descript: ""
				},
				{
					title: "KALBI DINNER (3strip)",
					price: "26.95",
					descript: ""
				},
				{
					title: "SWEET AND CHILE CHICKEN (KANPUNKI)",
					price: "18.95",
					descript: ""
				},
				{
					title: "SWEET AND SOUR PORK (TANGSUYUK)",
					price: "18.95",
					descript: ""
				},
				{
					title: "UNAGI DONBURI",
					price: "19.95",
					descript: ""
				},
				{
					title: "BEEF (GYU) DONBURI",
					price: "13.95",
					descript: ""
				},
				{
					title: "CHICKEN (OYAKU) OR SHRIMP TEMPURA DONBURI",
					price: "12.95",
					descript: ""
				},
				{
					title: "SPICY SEAFOOD SOFT TOFU (Soon DO BU)",
					price: "12.95",
					descript: ""
				},
				{
					title: "SPICY FISH STEW (COD)",
					price: "16.95",
					descript: "Korean style spicy fish stew with vegetables and rice"
				},
				{
					title: "SPICY BEEF STEW (YUK GAE JANG)",
					price: "13.95",
					descript: "Spicy beef broth with mixed vegetables"
				},
				{
					title: "KIMCHI STEW",
					price: "13.95",
					descript: "Pork, kimchi, tofu, vegetables in a spicy soup"
				},
				{
					title: "FRIED RICE",
					price: "11.95",
					descript: "Kimchi or vegetable or chicken or shrimp and rice and egg"
				},
				{
					title: "PORK BORN SOUP (GAM JA TANG)",
					price: "12.99",
					descript: "Kimchi or vegetable or chicken or shrimp and rice and egg"
				},
				],
			},
			{
				name: "SUSHI AND SASHIMI DINNERS (MISO SOUP & SALAD)",
				data: [
				{
					title: "MATSU SUSHI",
					price: "19.95",
					descript: "12pcs nigari sushi, 6pcs California maki"
				},
				{
					title: "SASHIMI DINNER",
					price: "20.95",
					descript: "20pcs fresh raw fish and seafood served with rice"
				},
				{
					title: "TAKE SUSHI",
					price: "17.95",
					descript: "10pcs nigari sushi, 6pcs California maki"
				},
				{
					title: "CHIRASHI SUSHI",
					price: "16.95",
					descript: "assorted sashimi and seafood on a bed of sushi rice"
				},
				{
					title: "LOVE BOAT",
					price: "29.95",
					descript: "6pcs California, 5pcs pink lady, 9pcs nigari and 9pcs sashimi"
				},
				],
			},
			{
				name: "DINNER (BENTO BOX) MISO SOUP AND GREEN SALAD",
				data: [
				{
					title: "MATSU BENTO BOX",
					price: "25.95",
					descript: "Sashimi, 3pcs sushi, and 12pcs maki"
				},
				{
					title: "SAKURA BENTO BOX",
					price: "24.95",
					descript: "5pcs sushi, 12pcs maki, shrimp and vegetable tempura"
				},
				{
					title: "FUJI BENTO",
					price: "24.95",
					descript: "6pcs maki, 3pcs sushi, shrimp and vegetable tempura, and teriyaki"
				},
				{
					title: "KIKU BENTO BOX",
					price: "24.95",
					descript: "6pcs maki, 3pcs sushi, shrimp and vegetable tempura, and bulgogi"
				},
				{
					title: "VEGGIE BENTO BOX",
					price: "23.95",
					descript: "3pcs inari, vegetable tempura, Victoria maki, asparagus maki, teriyaki"
				},
				],
			},
			{
				name: "PARTY TRAYS",
				data: [
				{
					title: "SMALL (33PCS)",
					price: "34.95",
					descript: "sushi & maki"
				},
				{
					title: "SMALL (33PCS)",
					price: "35.95",
					descript: "sashimi"
				},
				{
					title: "SMALL (33PCS)",
					price: "35.95",
					descript: "sushi & sashimi & maki"
				},
				{
					title: "SMALL (33PCS)",
					price: "34.95",
					descript: "maki"
				},
				{
					title: "MEDIUM (55PCS)",
					price: "54.95",
					descript: "sushi & maki"
				},
				{
					title: "MEDIUM (55PCS)",
					price: "55.95",
					descript: "sashimi"
				},
				{
					title: "MEDIUM (55PCS)",
					price: "55.95",
					descript: "sushi & sashimi & maki"
				},
				{
					title: "MEDIUM (55PCS)",
					price: "54.95",
					descript: "maki"
				},
				{
					title: "LARGE (76PCS)",
					price: "74.95",
					descript: "sushi & maki"
				},
				{
					title: "LARGE (76PCS)",
					price: "75.95",
					descript: "sashimi"
				},
				{
					title: "LARGE (76PCS)",
					price: "75.95",
					descript: "sushi & sashimi & maki"
				},
				{
					title: "LARGE (76PCS)",
					price: "74.95",
					descript: "maki"
				},
				{
					title: "X-LARGE (98PCS)",
					price: "94.95",
					descript: "sushi & maki"
				},
				{
					title: "X-LARGE (98PCS)",
					price: "95.95",
					descript: "sashimi"
				},
				{
					title: "X-LARGE (98PCS)",
					price: "95.95",
					descript: "sushi & sashimi & maki"
				},
				{
					title: "X-LARGE (98PCS)",
					price: "94.95",
					descript: "maki"
				},
				]
			}
			]
>>>>>>> simplify
		},

		created() {
			let cookieValue = JSON.parse(getCookie("ordersInCart"));

			cookieValue ? this.orderItems = cookieValue : console.log("no cookie");
<<<<<<< 206b94ce10319827f6348f99a360e53479e9642f

			axios.get('/menu/category').then( response => {
				// console.log(response.data);
				this.category = response.data;
			});

=======
>>>>>>> simplify
		},

		methods: {
			onOrderMenu(order) {
				// used in popup
				this.orderItemTitle = order.title;
				console.log(order);

				this.orderItems.push(order);
				// show order info popup
				this.ordered = true;
				
				// save cookie for 60 days
				setCookie("ordersInCart", JSON.stringify(this.orderItems), this.oneWeek);

				// update cart badges
				document.getElementById("cart-badge").textContent = this.orderItems.length;

				// order message disappears in 2 sec
				setTimeout(() => {
					this.ordered = false;
				}, 2 * 1000); 
			}
		}
	})
}