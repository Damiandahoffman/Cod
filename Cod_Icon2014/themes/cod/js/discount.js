function calculatediscounts(prices,Minticket,MinDiscount,Specialticket,SpecialDiscount)
{
		prices.sort(function(a, b){return a-b}); 
		prices.reverse(); 
		var discount = 0;
		// don't allow gain due to the discount - the discount can't be more than the cheapest ticket
		if (prices.length>0) 
		{
			MinDiscount = Math.min(Math.min.apply(Math, prices),MinDiscount);
		}
		discount = MinDiscount*Math.floor(prices.length/Minticket);			
		var totalPriceDisc = 0;		
			for(var i=0, n=prices.length; i < n; i++) 
			{ 
				totalPriceDisc += prices[i];
			}
			totalPriceDisc=totalPriceDisc-discount;
		return(totalPriceDisc);
}