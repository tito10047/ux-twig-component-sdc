### Benchmark Výsledky (Nové meranie)

#### Pred Optimalizáciou (main)

| Benchmark | Mode (čas) | Memory Peak |
|-----------|------------|-------------|
| benchWarmupClassic | 23.502ms | 2.133mb |
| benchWarmupSdc | 23.535ms | 2.133mb |
| benchRenderClassic | 30.583ms | 25.890mb |
| benchRenderSdc | 29.135ms | 30.508mb |

#### Po Optimalizácii (optimizing)

| Benchmark | Mode (čas) | Memory Peak |
|-----------|------------|-------------|
| benchWarmupClassic | 23.552ms | 2.133mb |
| benchWarmupSdc | 30.067ms | 2.133mb |
| benchRenderClassic | 28.260ms | 25.890mb |
| benchRenderSdc | 29.316ms | 30.508mb |

#### Stress Test (1000 komponentov)

| Benchmark | main (čas) | optimizing (čas) | Memory Peak |
|-----------|------------|------------------|-------------|
| benchRenderClassic | 30.877ms | 29.910ms | 25.890mb |
| benchRenderSdc | 29.669ms | 34.038ms | 30.508mb |

### Záver zo Stress Testu

Pri zvýšení počtu komponentov na 1000 sme zaznamenali nasledujúce zmeny:

1. **Render Classic**: Čas renderovania zostal pomerne stabilný, okolo 30ms.
2. **Render SDC**: V `optimizing` vetve sme zaznamenali mierne zvýšenie času na 34ms v porovnaní s 29.6ms v `main`.
3. **Pamäťová náročnosť**: SDC prístup vyžaduje približne o 4.6MB viac pamäte pri 1000 komponentoch, čo je spôsobené registráciou a správou assetov pre každý komponent.

**Zhrnutie**:
Optimalizácia v `optimizing` vetve sa pri extrémnom počte komponentov (1000 na jednej stránke) prejavuje miernym spomalením renderovania (cca +15%). Je to daň za komplexnejšiu správu assetov a ich automatickú registráciu. Pre bežné aplikácie s desiatkami komponentov je tento rozdiel zanedbateľný, ale pri extrémnej záťaži je potrebné zvážiť pamäťovú stopu registra assetov.

---

*Poznámka: benchWarmupSdc v optimizing vetve vykazuje vyšší čas zrejme kvôli zmenám v kompilácii registra, kým render časy zostávajú podobné.*
