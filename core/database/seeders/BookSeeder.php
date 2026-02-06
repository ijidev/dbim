<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookChapter;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            [
                'title' => 'Biblical Business Principle',
                'author' => 'Dr. Spiritual Mentor',
                'category' => 'Leadership',
                'description' => 'A comprehensive guide to building a kingdom-based business enterprise centered on divine principles and ethical integrity.',
                'chapters' => [
                    [
                        'title' => 'The Foundation of Stewardship',
                        'content' => "True business success begins with the understanding that we are managers, not owners. In Luke 16:11, the Bible asks, 'Therefore if you have not been faithful in the unrighteous mammon, who will commit to your trust the true riches?' Stewardship is the conscious recognition that every resource—capital, talent, and time—belongs to God. When a businessman views his company as a divine assignment, his decision-making shifts from short-term greed to long-term kingdom impact. This foundation requires a heart that is not tied to the money but to the Master. You must ask yourself daily: 'How would Jesus manage this department?' Stewardship also involves accountability. Just as the servants in the parable of the talents had to account for their multiplication, we must ensure that our businesses are growing and bearing fruit that honors the Creator."
                    ],
                    [
                        'title' => 'The Law of the Seed',
                        'content' => "Genesis 8:22 declares, 'While the earth remains, seedtime and harvest... shall not cease.' In the biblical business model, every investment is a seed. You cannot expect a harvest where you have not planted. This law applies to financial capital, but also to kindness, service, and value. If you want a loyal customer base, you must first plant seeds of exceptional service. The principle of the seed requires patience. Many entrepreneurs fail because they want the harvest in the same season they planted the seed. However, the spiritual law dictates that there is a 'time' between the seed and the harvest. During this waiting period, your faith keeps the seed in the ground. Multiplication happens when the seed dies to its original form and rises as a fruitful tree."
                    ],
                    [
                        'title' => 'Integrity: The Business Currency',
                        'content' => "Proverbs 11:1 tells us that 'Dishonest scales are an abomination to the Lord, but a just weight is His delight.' In a world where cutting corners is often celebrated, the believer must stand on the rock of integrity. Integrity is not just about being legal; it is about being biblical. It means keeping your word even when it hurts your profit margin (Psalm 15:4). When customers know that your 'yes' is 'yes' and your 'no' is 'no,' they develop a level of trust that no marketing budget can buy. Your brand is ultimately a reflection of your character. A business built on deception is like a house built on sand; it might look grand for a moment, but it will surely crumble under the pressure of the storm."
                    ],
                    [
                        'title' => 'Diligence and Excellence',
                        'content' => "Diligence is the engine of promotion. Proverbs 22:29 says, 'Do you see a man who excels in his work? He will stand before kings; he will not stand before unknown men.' Biblical business success is not just about prayer; it is about the pairing of spiritual devotion with professional excellence. Excellence is doing a common thing in an uncommon way. It is the refusal to settle for 'good enough.' When Joseph was in Egypt, his excellence made him indispensable to Pharaoh. Whether you are coding a software, baking bread, or managing a global supply chain, your work should be a testimony of the God you serve. Diligence means being consistent, being punctual, and being proactive."
                    ],
                    [
                        'title' => 'Multiplication vs. Addition',
                        'content' => "God is the God of multiplication. In the parable of the talents (Matthew 25), the master expected a return on the investment. Addition is a linear process, but multiplication is exponential. In business, multiplication happens through systems, delegation, and divine favor. You cannot multiply what you cannot manage. For a business to scale, it must move beyond the personality of the founder. Principles of multiplication require the courage to take risks. The servant who hid his talent was reprimanded because fear is the enemy of multiplication. To enter the 'joy of the master,' one must be willing to trade and expand the resources given."
                    ],
                    [
                        'title' => 'Dealing with Debt',
                        'content' => "The Bible warns that 'the borrower is servant to the lender' (Proverbs 22:7). While the modern financial world is built on leverage, the biblical principle encourages a debt-free lifestyle. Debt creates a burden that can hinder your ability to obey God's leading. Romans 13:8 instructs us to 'Owe no one anything except to love one another.' A kingdom business aims to be the lender, not the borrower. This requires disciplined financial planning and avoiding the snare of consumerism. Financial freedom allows a business to be agile and responsive to the whispers of the Holy Spirit."
                    ],
                    [
                        'title' => 'Divine Connection and Partnerships',
                        'content' => "Ecclesiastes 4:9 says, 'Two are better than one, because they have a good reward for their labor.' In business, who you walk with determines where you end up. However, the Bible also warns against being 'unequally yoked' (2 Corinthians 6:14). Divine connections are relationships orchestrated by God to accelerate your purpose. A kingdom partnership is one where both parties are aligned in values and vision. It is not just about merging assets; it is about merging spirits. When God brings a Barnabas or a Timothy into your business life, cherish the relationship and nurture it with mutual respect."
                    ],
                    [
                        'title' => 'Generosity in the Marketplace',
                        'content' => "The ultimate goal of a biblical business is to become a channel of blessing. Luke 6:38 promises, 'Give, and it will be given to you: good measure, pressed down, shaken together, and running over.' Generosity is the antidote to the spirit of Mammon. Whether through tithing, supporting missions, or helping the poor, a generous business invites the protection and provision of God. Generosity also extends to how you treat your employees. Paying fair wages and providing for their needs is a scriptural mandate (James 5:4). A business that gives is a business that God can trust with more."
                    ]
                ]
            ],
            [
                'title' => 'The Skilful Prayer',
                'author' => 'Apostle of Faith',
                'category' => 'Devotional',
                'description' => 'Unlocking the strategic dimensions of prayer to experience consistent results and deeper intimacy with the Father.',
                'chapters' => [
                    [
                        'title' => 'Understanding the Secret Place',
                        'content' => "Prayer is not a public performance; it is a private communion. Matthew 6:6 instructs, 'But you, when you pray, go into your room, and when you have shut your door, pray to your Father who is in the secret place.' The secret place is where the noise of the world is silenced and the frequency of heaven is heard. It is a place of vulnerability and honesty. In the secret place, masks are dropped and hearts are laid bare. It is here that spiritual strength is renewed and divine strategies are downloaded. Intimacy precedes impact. Before you can stand before men, you must first kneel before God."
                    ],
                    [
                        'title' => 'The Power of Fasting',
                        'content' => "Fasting is not an attempt to change God; it is an exercise to change us. It is the putting down of the flesh so that the spirit can arise. Isaiah 58 describes the 'chosen fast' that breaks the bands of wickedness and undoes heavy burdens. When we fast, we are declaring that our hunger for God is greater than our hunger for food. Fasting sensitizes our spiritual ears. It clears the static of carnal desires and allows us to perceive the subtle leanings of the Holy Spirit. A skilful prayer life often incorporates regular seasons of fasting to maintain spiritual sharpenss."
                    ],
                    [
                        'title' => 'Praying the Word',
                        'content' => "The word of God is the legal ground for prayer. Hebrews 4:12 says the Word is 'living and powerful.' When you pray the Word, you are bringing God's own promises back to Him. It is like an attorney citing the law in a courtroom. God is bound by His Word (Psalm 138:2). Therefore, the most effective prayers are those saturated with scripture. Instead of just complaining about your problems, find a verse that addresses the situation and declare it with authority. The Word is the sword of the Spirit; without it, your prayer life is defenseless."
                    ],
                    [
                        'title' => 'Persistent Intercession',
                        'content' => "Luke 18:1 tells us that 'men always ought to pray and not lose heart.' Persistence is the proof of desire. Some answers come immediately, but others require a 'laboring' in the spirit. Think of Elijah on Mount Carmel, praying seven times before the cloud appeared. Persistence is not pestering a reluctant God; it is standing in faith until the manifestation occurs. Intercession is the act of standing in the gap for others. It is the highest form of prayer because it is selfless. When you intercede, you are partnering with Jesus, our Great High Priest, who ever lives to make intercession for us."
                    ],
                    [
                        'title' => 'The Language of the Spirit',
                        'content' => "1 Corinthians 14:2 explains, 'For he who speaks in a tongue does not speak to men but to God.' Praying in the Spirit is a supernatural tool for building up your inner man (Jude 1:20). It allows you to pray beyond your mental limitations. There are times when 'we do not know what we should pray for as we ought,' and that is when the Holy Spirit helps our weaknesses with groanings that cannot be uttered (Romans 8:26). Skilful prayers leverage this gift to tap into the mysteries of the Kingdom and to offer perfect prayers that bypass human intellect."
                    ],
                    [
                        'title' => 'Spiritual Warfare in Prayer',
                        'content' => "Ephesians 6:12 reminds us that 'we do not wrestle against flesh and blood, but against principalities, against powers.' Prayer is a battlefield. There are spiritual resistances that try to block your answers, much like the Prince of Persia hindered Daniel's answer for twenty-one days (Daniel 10:13). Skilful warfare involves wearing the whole armor of God and using the authority of the name of Jesus to bind and loose. It is not shouting at the devil; it is enforcing the victory of the Cross. When you understand your authority, your prayers become decrees that shift the atmosphere."
                    ],
                    [
                        'title' => 'Hearing the Voice of God',
                        'content' => "Prayer is a dialogue, not a monologue. John 10:27 says, 'My sheep hear My voice, and I know them, and they follow Me.' A major part of skilful prayer is the ability to be still and listen. God speaks through the 'still small voice,' through the Word, and through inner witnesses. After you have poured out your heart, give space for the Father to speak back. Carry a journal with you. Write down the impressions, images, or verses that come to your mind. Hearing God's voice transforms prayer from a religious ritual into a vibrant relationship."
                    ],
                    [
                        'title' => 'Result-Oriented Prayer',
                        'content' => "James 5:16 declares, 'The effective, fervent prayer of a righteous man avails much.' We are not called to pray for the sake of praying; we are called to get results. Biblical prayer has an objective. Whether it is healing, provision, or direction, you should expect to see the answer. This requires faith and a heart that is aligned with the will of God. If we ask anything according to His will, He hears us (1 John 5:14). Result-oriented prayer is marked by a confidence that the Father is both able and willing to intervene in the affairs of His children."
                    ]
                ]
            ],
            [
                'title' => 'The Effective Leadership',
                'author' => 'Bishop Wisdom',
                'category' => 'Leadership',
                'description' => 'Modeling leadership after the patterns of Christ and the great biblical reformers to influence generations.',
                'chapters' => [
                    [
                        'title' => 'Character: The Root of Influence',
                        'content' => "Leadership is not a title; it is a trust. The foundation of any effective leader is character. In the book of Nehemiah, we see a leader whose integrity was so strong that even his enemies couldn't find a valid accusation against him. Character is what you do when no one is watching. It is the consistency between your public persona and your private life. A leader without character is like a ship without a rudder; they might have the wind of talent, but they will eventually crash on the rocks of compromise. High-capacity leadership requires high-integrity living. If your character cannot sustain your gift, your gift will eventually destroy you."
                    ],
                    [
                        'title' => 'Service: The Heart of the King',
                        'content' => "Jesus redefined leadership when He said, 'The Son of Man did not come to be served, but to serve' (Matthew 20:28). In the Kingdom, the way up is down. Servant-leadership is not a strategy; it is a heart condition. It means putting the needs of the team and the mission above personal comfort. When Jesus washed the disciples' feet, He was demonstrating that no task is too menial for a true leader. Effective leaders don't use people to build their vision; they use their vision to build people. When you serve those you lead, you earn a level of loyalty that command-and-control styles can never achieve."
                    ],
                    [
                        'title' => 'Purpose and Vision Casting',
                        'content' => "Proverbs 29:18 warns, 'Where there is no vision, the people perish.' A leader's primary job is to see further and clearer than others. Vision is a mental picture of a preferable future. But vision alone is not enough; a leader must be able to cast that vision effectively. This involves communicating the 'why' behind the 'what.' When people understand the purpose, they are willing to endure the process. Vision casting requires clarity, passion, and repetition. You must keep the vision before the people until it becomes part of their own heartbeat. A shared vision is a powerful force for unity."
                    ],
                    [
                        'title' => 'Team Building and Delegation',
                        'content' => "Exodus 18 shows Jethro advising Moses to delegate tasks. No leader is meant to be a 'one-man show.' Effective leadership is about identifying the gifts in others and Empowering them to lead in their areas of strength. Delegation is not just offloading work; it is developing people. It requires the humility to accept that someone else might do the task differently (and perhaps better) than you. Building a team means creating a culture of trust and collaboration. A leader is only as strong as the people they surround themselves with. Your ultimate legacy is measured by the leaders you leave behind."
                    ],
                    [
                        'title' => 'Conflict Resolution and Wisdom',
                        'content' => "Conflicts are inevitable in any organization. James 3:17 describes the 'wisdom that is from above' as being pure, peaceable, gentle, and willing to yield. An effective leader does not avoid conflict but manages it with grace and truth. This requires the ability to listen to all sides without prejudice. Resolution is not about finding who is right, but finding what is right for the mission. It involves tough conversations and sometimes difficult decisions. A leader who can navigate the waters of disagreement without sinking the ship of unity is a leader of great value."
                    ],
                    [
                        'title' => 'Accountability and Feedback',
                        'content' => "Accountability is the safeguard of leadership. Even King David had a Nathan to speak truth to his life. No leader is above the law or above correction. Effective leaders create systems of accountability where they are answerable to others. Feedback is the breakfast of champions. A leader who stops listening to feedback has stopped growing. Cultivate a culture where people feel safe to share their thoughts and where truth is valued over flattery. Accountability keeps your feet on the ground and your eyes on the goal."
                    ],
                    [
                        'title' => 'Resilience in the Face of Opposition',
                        'content' => "Leadership often attracts criticism. Nehemiah faced Sanballat and Tobiah, who ridiculed his work. Resilience is the ability to stay focused on the wall despite the noise of the mockers. 2 Corinthians 4:8-9 says, 'We are hard-pressed on every side, yet not crushed; we are perplexed, but not in despair.' A leader must have 'thick skin and a soft heart.' Don't let the critics determine your pace. Use the stones thrown at you to build the foundation of your persistence. Your conviction must be deeper than the disapproval of men."
                    ],
                    [
                        'title' => 'Legacy: Finishing Well',
                        'content' => "The goal of leadership is not just to start well, but to finish well. 2 Timothy 4:7 record Paul saying, 'I have fought the good fight, I have finished the race, I have kept the faith.' Legacy is about what happens after you are gone. Effective leaders prepare for succession long before they step down. They invest their lives in the next generation. Your greatest contribution is not the buildings you built or the programs you started, but the character and competence you instilled in those you led. Lead today with an eye on tomorrow."
                    ]
                ]
            ],
            [
                'title' => 'Choosing the Right Partner to Marry',
                'author' => 'Pastor Mark & Sarah',
                'category' => 'Faith',
                'description' => 'A biblical framework for selecting a life partner that aligns with your spiritual destiny and emotional well-being.',
                'chapters' => [
                    [
                        'title' => 'Spiritual Compatibility',
                        'content' => "2 Corinthians 6:14 is the primary anchor for marital selection: 'Do not be unequally yoked together with unbelievers.' Marriage is the merging of two lives into one. If your spirits are moving in different directions, your life will be filled with friction. Spiritual compatibility is more than just attending the same church. it is about a shared commitment to the Lordship of Christ. When both partners have the same Master, they have a common ground for resolution and growth. Don't settle for someone you hope to change; choose someone whose walk with God inspires your own."
                    ],
                    [
                        'title' => 'Shared Values and Worldviews',
                        'content' => "Amos 3:3 asks, 'Can two walk together, unless they are agreed?' Beyond spiritual belief, there must be agreement on core values—finances, family, ministry, and lifestyle. If one values frugality and the other values luxury, there will be constant tension. If one wants a quiet life and the other wants a global impact, purpose will be frustrated. Discuss these things early. Your values are the compass of your life. If your compasses are pointing in different directions, you will eventually drift apart. Agreement is the environment where the blessing of God flows."
                    ],
                    [
                        'title' => 'Emotional Health and Maturity',
                        'content' => "Marriage does not heal emotional wounds; it often exposes them. Before choosing a partner, evaluate their emotional maturity. Do they have self-control? (Proverbs 25:28). How do they handle anger or disappointment? A partner who is emotionally unstable will make for a turbulent home. Look for someone who has taken responsibility for their own healing and growth. Maturity is the ability to prioritize the relationship over the ego. You need a partner who can communicate their needs without manipulation and who can hear yours without defensiveness."
                    ],
                    [
                        'title' => 'Purpose Alignment',
                        'content' => "When God made Eve, He called her a 'helper comparable to him' (Genesis 2:18). This implies that Adam had a task (a purpose) that Eve was designed to help fulfill. Marriage is two purposes becoming one mission. If your partner's destination is not compatible with your calling, there will be a tug-of-war. Ask: 'Does this person make me more effective in my divine assignment?' A right partner is an accelerator of your destiny, not a distraction. Your marriage should be a platform from which you both fulfill the Great Commission."
                    ],
                    [
                        'title' => 'The Role of Communication',
                        'content' => "Proverbs 18:21 says, 'Death and life are in the power of the tongue.' Communication is the lifeblood of a relationship. Observe how your potential partner speaks to their parents, to waiters, and to you during a disagreement. Do they listen? Do they value truth? Can they apologize? A partner who cannot communicate effectively will leave you feeling isolated and misunderstood. Communication is a skill that can be learned, but the willingness to communicate is a character trait you must look for from the beginning."
                    ],
                    [
                        'title' => 'Purity and Honor',
                        'content' => "Hebrews 13:4 declares, 'Marriage is honorable among all, and the bed undefiled.' Honor is the atmosphere of a healthy relationship. A partner who honors you will respect your boundaries and your walk with God. Purity is not just a rule; it is a protection of the intimacy you will share in marriage. Someone who pressures you to compromise your convictions before marriage is unlikely to respect your convictions after marriage. Look for a partner who values your holiness above their own pleasure."
                    ],
                    [
                        'title' => 'Wisdom in Selection',
                        'content' => "Proverbs 4:7 says, 'Wisdom is the principal thing.' While chemistry and attraction are important, they are not enough to sustain a 50-year commitment. Use wisdom. Observe the person in different environments—with friends, under pressure, and in service. Seek the counsel of godly mentors and parents. 'In the multitude of counselors there is safety' (Proverbs 11:14). Don't rush; a lifetime of regret is not worth a moment of excitement. Let the peace of God be your umpire as you make this critical decision."
                    ],
                    [
                        'title' => 'Marriage as a Covenant',
                        'content' => "Marriage is not a contract that can be broken; it is a covenant that must be kept. Matthew 19:6 says, 'What God has joined together, let not man separate.' In a covenant, you give 100% regardless of what you get back. It is a commitment to stay when things get tough. Look for a partner who understands the weight of a covenant. You need someone who is not looking for an exit strategy but is committed to building a lasting legacy. A covenant marriage is a reflection of Christ's love for the Church—unconditional, enduring, and sacrificial."
                    ]
                ]
            ],
            [
                'title' => "Believe: The Gateway to the Supernatural",
                'author' => 'Prophet of Grace',
                'category' => 'Faith',
                'description' => 'Exploring the mechanics of faith and the spiritual laws that govern the manifestation of the supernatural in a believers life.',
                'chapters' => [
                    [
                        'title' => 'Faith as a Spiritual Bridge',
                        'content' => "Hebrews 11:1 defines faith as 'the substance of things hoped for, the evidence of things not seen.' Faith is the bridge between the invisible realm of the Spirit and the visible realm of the physical. It is how we reach into the treasury of heaven and pull out our provision. Believe is a verb—it is an action. To believe is to act as if the Word of God is true, regardless of what your senses tell you. Your physical eyes see the mountain, but your spiritual eyes see the mountain removed. Faith is not denial of reality; it is the invitation of a higher reality."
                    ],
                    [
                        'title' => 'Understanding Spiritual Law',
                        'content' => "The spiritual world is not chaotic; it is governed by laws. Romans 8:2 speaks of the 'law of the Spirit of life in Christ Jesus.' Just as gravity is a law in the physical world, faith is a law in the spiritual world. One of the primary laws is the Law of Faith (Romans 3:27). This law dictates that God responds to faith, not just to need. You can have a great need and still be defeated, but when you apply the law of faith, the supernatural intervention of God is activated. Learning these laws allows you to walk in the supernatural with consistency."
                    ],
                    [
                        'title' => 'The Power of Affirmation',
                        'content' => "Mark 11:23 says, '...whoever says to this mountain... and does not doubt in his heart, but believes that those things he says will be done, he will have whatever he says.' Your mouth is the release valve of your faith. Affirmation is the act of speaking the Word of God over your life. It is not just positive thinking; it is spiritual decreeing. When you align your confession with God's Word, you create a resonance with heaven. Your words frame your world (Hebrews 11:3). Stop talking about your sickness and start talking about your healing. Stop talking about your lack and start talking about your abundance."
                    ],
                    [
                        'title' => 'The Renewed Mind',
                        'content' => "Romans 12:2 instructs us to 'be transformed by the renewing of your mind.' Your mind is the filter for your faith. If your mind is filled with doubt, fear, and logical impossibilities, it will choke the seed of faith. The gateway to the supernatural requires a mind that is saturated with the possibilities of God. Renewing the mind involves replacing worldly logic with heavenly truth. It is seeing through the lens of 'all things are possible to him who believes' (Mark 9:23). A mind that thinks like God can believe for what only God can do."
                    ],
                    [
                        'title' => 'Miracles: The Norm of the Kingdom',
                        'content' => "In the early church, signs and wonders were everyday occurrences. Jesus said, 'These signs will follow those who believe' (Mark 16:17). Miracles are not meant to be rare exceptions; they are meant to be the norm for the believer. A miracle is simply the intervention of a higher spiritual law over a lower physical law. When you walk in faith, you shouldn't be surprised by the supernatural; you should be surprised by the lack of it. Miracles are the Father's way of confirming His Word and demonstrating His love to a world that needs to see His power."
                    ],
                    [
                        'title' => 'The Holy Spirit: Our Supernatural Partner',
                        'content' => "Acts 1:8 promises, 'You shall receive power when the Holy Spirit has come upon you.' The Holy Spirit is the executor of the supernatural on earth. He is the one who performs the miracles, gives the words of wisdom, and empowers the believer. Without the Holy Spirit, faith is just a mental exercise. Intimacy with the Spirit is the secret behind every supernatural ministry. He is the 'Helper' who guides us into all truth and shows us things to come. When you partner with the Holy Spirit, your limitations are removed, and His power becomes your reality."
                    ],
                    [
                        'title' => 'Overcoming the Giant of Fear',
                        'content' => "Fear is the opposite of faith. 2 Timothy 1:7 says, 'God has not given us a spirit of fear, but of power and of love and of a sound mind.' Fear is the gateway to the demonic, just as faith is the gateway to the supernatural. Fear paralyzes your ability to believe. To walk in the supernatural, you must ruthlessly confront and cast out fear. This is done through the perfect love of God (1 John 4:18) and the persistent declaration of the Word. When faith rises, fear must flee. You cannot hold both a seed of doubt and a tree of faith at the same time."
                    ],
                    [
                        'title' => 'Living in Kingdom Reality',
                        'content' => "The supernatural is not a place you visit; it is a realm you live in. Colossians 1:13 says we have been 'delivered from the power of darkness and conveyed into the kingdom of the Son of His love.' Living in kingdom reality means being conscious of your identity as an ambassador of Christ. It is walking with the awareness that the resources of heaven are at your disposal. This lifestyle is marked by peace, joy, and constant communion with the Father. When you live from the Kingdom perspective, the 'impossible' becomes your everyday playground."
                    ]
                ]
            ]
        ];

        foreach ($books as $bData) {
            $chapters = $bData['chapters'];
            unset($bData['chapters']);

            $bData['slug'] = Str::slug($bData['title']);
            $bData['is_free'] = true;
            $bData['status'] = 1; // Published
            $bData['pages'] = count($chapters) * 12; // Approx 100 pages total for 8 chapters
            $bData['price'] = 0.00;
            $bData['content'] = $chapters[0]['content']; // Lead content
            
            $book = Book::create($bData);

            foreach ($chapters as $index => $cData) {
                BookChapter::create([
                    'book_id' => $book->id,
                    'title' => $cData['title'],
                    'slug' => Str::slug($cData['title']),
                    'content' => $cData['content'],
                    'order' => $index + 1
                ]);
            }
        }
    }
}
